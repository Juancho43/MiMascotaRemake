<?php

namespace App\MiMascota\Images\Infrastructure;

use App\MiMascota\Images\Domain\IDeleteImage;

final readonly class SystemFileDeleter implements IDeleteImage
{
 public function delete(string $path): void
 {
     if (!file_exists($path) || !unlink($path)) {
         throw new \RuntimeException("Could not delete the file at: " . $path);
     }
 }
}
