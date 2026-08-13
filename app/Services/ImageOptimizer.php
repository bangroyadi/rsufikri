<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageOptimizer
{
    /**
     * Compress and save an uploaded file to specified storage directory.
     * Returns the relative storage path (e.g. 'services/filename.jpg').
     */
    public static function optimizeAndStore(UploadedFile $file, string $folder, int $maxWidth = 1400, int $quality = 82): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = md5(uniqid(microtime(), true)) . '.' . ($extension === 'png' ? 'png' : 'jpg');
        $destinationPath = storage_path('app/public/' . $folder);

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $targetFile = $destinationPath . '/' . $filename;
        $tempPath = $file->getRealPath();

        self::compressImageFile($tempPath, $targetFile, $extension, $maxWidth, $quality);

        return $folder . '/' . $filename;
    }

    /**
     * Compress any existing file on disk in place or to a target path.
     */
    public static function compressImageFile(string $sourcePath, string $targetPath, string $extension = '', int $maxWidth = 1400, int $quality = 82): bool
    {
        if (!file_exists($sourcePath)) {
            return false;
        }

        if (empty($extension)) {
            $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        }

        list($origWidth, $origHeight, $type) = @getimagesize($sourcePath);

        if (!$origWidth || !$origHeight) {
            if ($sourcePath !== $targetPath) {
                copy($sourcePath, $targetPath);
            }
            return true;
        }

        $newWidth = $origWidth;
        $newHeight = $origHeight;

        if ($origWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(($origHeight / $origWidth) * $maxWidth);
        }

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

        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        if ($type === IMAGETYPE_PNG) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
            imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        if ($type === IMAGETYPE_PNG) {
            $pngQuality = (int) round((100 - $quality) / 10);
            imagepng($canvas, $targetPath, max(0, min(9, $pngQuality)));
        } else {
            imagejpeg($canvas, $targetPath, $quality);
        }

        imagedestroy($image);
        imagedestroy($canvas);

        return true;
    }
}
