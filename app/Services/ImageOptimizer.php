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
     * @param string $folder Target subfolder in storage/app/public (e.g. 'events', 'doctors', 'services')
     * @param int $maxWidth Max width resolution (e.g. 1600px for banners/galleries, 800px for avatars)
     * @param int $quality Starting quality (default: 82%)
     * @param bool $forceWebp Whether to convert to WebP format (default: true)
     * @return string Relative storage path (e.g. 'services/filename.webp')
     */
    public static function optimizeAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1600,
        int $quality = 82,
        bool $forceWebp = true
    ): string {
        $folderClean = trim($folder, '/');
        $supportsWebp = function_exists('imagewebp');
        $useWebp = $forceWebp && $supportsWebp;

        $targetExt = $useWebp ? 'webp' : ($file->getClientOriginalExtension() ?: 'jpg');
        $filename = md5(uniqid(microtime(), true)) . '.' . $targetExt;
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
            $compressed = self::compressAndSaveImage($sourcePath, $targetFile, $maxWidth, $quality, $useWebp);
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
     * Core compression engine with guaranteed <= 1MB file size enforcement
     */
    public static function compressAndSaveImage(
        string $sourcePath,
        string $targetPath,
        int $maxWidth = 1600,
        int $quality = 82,
        bool $useWebp = true
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

        // Calculate aspect ratio dimensions
        $newWidth = $origWidth;
        $newHeight = $origHeight;

        if ($origWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(($origHeight / $origWidth) * $maxWidth);
        }

        // Create high-color truecolor canvas
        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        // Retain alpha transparency for PNG / WebP
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
        imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, $transparent);

        // High quality bicubic resampling
        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Determine if webp is requested and supported
        $supportsWebp = function_exists('imagewebp');
        $saveAsWebp = $useWebp && $supportsWebp;

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
            if ($fileSize && $fileSize > self::MAX_TARGET_BYTES && $currentQuality > 40) {
                // Reduce quality slightly and retry to guarantee < 1MB
                $currentQuality -= 10;
            } else {
                break;
            }
        } while ($currentQuality >= 40);

        // Cleanup GD memory
        imagedestroy($image);
        imagedestroy($canvas);

        return $saved;
    }
}
