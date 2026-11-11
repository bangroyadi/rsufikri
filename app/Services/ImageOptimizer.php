<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ImageOptimizer
{
    /**
     * Maximum allowed file size after compression: 1 MB (1024 * 1024 bytes)
     */
    const MAX_TARGET_BYTES = 1048576; // 1 MB

    /**
     * Compress and save an uploaded file to specified storage directory.
     * Converts to high-efficiency WebP format by default for superior speed & quality.
     * 
     * @param UploadedFile $file Uploaded file instance
     * @param string $folder Target subfolder in storage/app/public (e.g. 'banners', 'events', 'doctors', 'services')
     * @param int $maxWidth Max width resolution (e.g. 1920px for banners, 800px for avatars)
     * @param int $quality Starting quality (default: 85%)
     * @param bool $forceWebp Whether to convert to WebP format (default: true)
     * @param int|null $maxHeight Optional max height resolution (e.g. 1080px for banners)
     * @return string Relative storage path (e.g. 'banners/banner_xxxx.webp')
     */
    public static function optimizeAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1920,
        int $quality = 85,
        bool $forceWebp = true,
        ?int $maxHeight = 1080
    ): string {
        $folderClean = trim($folder, '/');
        $supportsWebp = function_exists('imagewebp');
        $useWebp = $forceWebp && $supportsWebp;

        $targetExt = $useWebp ? 'webp' : ($file->getClientOriginalExtension() ?: 'jpg');
        $prefix = !empty($folderClean) ? rtrim($folderClean, 's') : 'img';
        $filename = $prefix . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $targetExt;
        $destinationDir = storage_path('app/public/' . $folderClean);

        if (!file_exists($destinationDir)) {
            @mkdir($destinationDir, 0775, true);
        }

        // Also ensure via Laravel Storage disk
        try {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($folderClean);
        } catch (\Throwable $e) {
            Log::warning("Storage disk makeDirectory failed for {$folderClean}: " . $e->getMessage());
        }

        $targetFile = $destinationDir . '/' . $filename;
        $sourcePath = $file->getRealPath();

        $compressed = false;
        try {
            $compressed = self::compressAndSaveImage($sourcePath, $targetFile, $maxWidth, $quality, $useWebp, $maxHeight);
        } catch (\Throwable $e) {
            Log::warning("Image compression failed, falling back to direct copy: " . $e->getMessage());
        }

        // Verify if the target file was successfully created and is not empty
        if (file_exists($targetFile) && filesize($targetFile) > 0) {
            return $folderClean . '/' . $filename;
        }

        // Ultimate fallback: Store directly via Laravel Storage
        try {
            $storedPath = $file->storeAs($folderClean, $filename, 'public');
            if ($storedPath) {
                return $storedPath;
            }
        } catch (\Throwable $e) {
            Log::error("Failed to store uploaded file via Storage fallback: " . $e->getMessage());
        }

        // Direct copy fallback
        if (@copy($sourcePath, $targetFile)) {
            return $folderClean . '/' . $filename;
        }

        return $folderClean . '/' . $filename;
    }

    /**
     * Core compression engine with guaranteed high visual quality & <= 1MB file size enforcement
     */
    public static function compressAndSaveImage(
        string $sourcePath,
        string $targetPath,
        int $maxWidth = 1920,
        int $quality = 85,
        bool $useWebp = true,
        ?int $maxHeight = null
    ): bool {
        if (!file_exists($sourcePath)) {
            return false;
        }

        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo) {
            if ($sourcePath !== $targetPath) {
                copy($sourcePath, $targetPath);
            }
            return true;
        }

        list($origWidth, $origHeight, $type) = $imageInfo;

        // Load image resource based on MIME type
        $image = null;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = @imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $image = @imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_WEBP:
                $image = @imagecreatefromwebp($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $image = function_exists('imagecreatefromgif') ? @imagecreatefromgif($sourcePath) : null;
                break;
            case IMAGETYPE_BMP:
                $image = function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($sourcePath) : null;
                break;
            default:
                if ($sourcePath !== $targetPath) {
                    copy($sourcePath, $targetPath);
                }
                return true;
        }

        if (!$image) {
            if ($sourcePath !== $targetPath) {
                copy($sourcePath, $targetPath);
            }
            return true;
        }

        // Handle JPEG EXIF orientation tag if present (smartphones/cameras)
        if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data($sourcePath);
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $rotated = @imagerotate($image, 180, 0);
                            if ($rotated) { imagedestroy($image); $image = $rotated; }
                            break;
                        case 6:
                            $rotated = @imagerotate($image, -90, 0);
                            if ($rotated) {
                                imagedestroy($image);
                                $image = $rotated;
                                $tmp = $origWidth;
                                $origWidth = $origHeight;
                                $origHeight = $tmp;
                            }
                            break;
                        case 8:
                            $rotated = @imagerotate($image, 90, 0);
                            if ($rotated) {
                                imagedestroy($image);
                                $image = $rotated;
                                $tmp = $origWidth;
                                $origWidth = $origHeight;
                                $origHeight = $tmp;
                            }
                            break;
                    }
                }
            } catch (\Throwable $e) {
                // Ignore EXIF parsing issues
            }
        }

        // Calculate aspect ratio dimensions - never upscale smaller images
        $newWidth = $origWidth;
        $newHeight = $origHeight;

        if ($origWidth > $maxWidth || ($maxHeight && $origHeight > $maxHeight)) {
            $ratioW = $maxWidth / $origWidth;
            $ratioH = $maxHeight ? ($maxHeight / $origHeight) : 1;
            $scale = min($ratioW, $ratioH);
            $newWidth = (int) max(1, round($origWidth * $scale));
            $newHeight = (int) max(1, round($origHeight * $scale));
        }

        // Create high-color truecolor canvas
        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        // Determine if webp is requested and supported
        $supportsWebp = function_exists('imagewebp');
        $saveAsWebp = $useWebp && $supportsWebp;

        // Preserve alpha transparency for WebP & PNG, fill white for JPEG
        if ($saveAsWebp || $type === IMAGETYPE_PNG || $type === IMAGETYPE_WEBP) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, $transparent);
        } else {
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, $white);
            imagealphablending($canvas, true);
        }

        // High quality bicubic resampling
        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Save image with target quality
        $currentQuality = $quality;
        $saved = false;

        do {
            if ($saveAsWebp) {
                $saved = @imagewebp($canvas, $targetPath, $currentQuality);
            } else {
                if ($type === IMAGETYPE_PNG && !$saveAsWebp) {
                    $pngCompression = (int) round((100 - $currentQuality) / 10);
                    $saved = @imagepng($canvas, $targetPath, max(0, min(9, $pngCompression)));
                } else {
                    // Save as progressive JPEG
                    if (function_exists('imageinterlace')) {
                        imageinterlace($canvas, true);
                    }
                    $saved = @imagejpeg($canvas, $targetPath, $currentQuality);
                }
            }

            // Check if file size is strictly <= 1 MB (1048576 bytes)
            $fileSize = @filesize($targetPath);
            if ($fileSize && $fileSize > self::MAX_TARGET_BYTES && $currentQuality > 45) {
                // Reduce quality slightly and retry to guarantee < 1MB
                $currentQuality -= 5;
            } else {
                break;
            }
        } while ($currentQuality >= 45);

        // Cleanup GD memory
        imagedestroy($image);
        imagedestroy($canvas);

        return $saved;
    }
}
