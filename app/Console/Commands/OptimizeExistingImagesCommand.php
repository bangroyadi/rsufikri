<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImageOptimizer;

class OptimizeExistingImagesCommand extends Command
{
    protected $signature = 'images:optimize {--max-size=1048576 : Max size in bytes (default 1MB)}';
    protected $description = 'Compress and optimize existing oversized images in public and storage directories to under 1MB';

    public function handle(): int
    {
        $maxBytes = (int) $this->option('max-size');
        $this->info("Scanning images larger than " . round($maxBytes / 1024 / 1024, 2) . " MB...");

        $directories = [
            public_path(),
            storage_path('app/public'),
        ];

        $optimizedCount = 0;
        $savedBytesTotal = 0;

        foreach ($directories as $dir) {
            if (!is_dir($dir)) continue;

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if (!$file->isFile()) continue;

                $ext = strtolower($file->getExtension());
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'bmp', 'webp'])) continue;

                $filePath = $file->getRealPath();
                $size = $file->getSize();

                // Check if file is large (> 500 KB or > maxBytes)
                if ($size > 512000) { // 500 KB threshold
                    $this->line("Optimizing: " . $file->getFilename() . " (" . round($size / 1024, 1) . " KB)...");

                    $tempTarget = $filePath . '.tmp';
                    $success = ImageOptimizer::compressAndSaveImage(
                        $filePath,
                        $tempTarget,
                        1600,
                        82,
                        $ext === 'webp' // keep webp if already webp, or compress in-place
                    );

                    if ($success && file_exists($tempTarget)) {
                        $newSize = filesize($tempTarget);
                        if ($newSize < $size) {
                            rename($tempTarget, $filePath);
                            $saved = $size - $newSize;
                            $savedBytesTotal += $saved;
                            $optimizedCount++;
                            $this->info("  -> Reduced to " . round($newSize / 1024, 1) . " KB (Saved " . round($saved / 1024, 1) . " KB)");
                        } else {
                            @unlink($tempTarget);
                        }
                    }
                }
            }
        }

        $this->newLine();
        $this->info("Optimization completed! Processed {$optimizedCount} images. Total bandwidth saved: " . round($savedBytesTotal / 1024 / 1024, 2) . " MB.");

        return Command::SUCCESS;
    }
}
