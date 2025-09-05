<?php

namespace App\MiMascota\Images\Infrastructure;

use App\MiMascota\Images\Application\StoreImage;

class FileSystemImageStore implements StoreImage
{

 public function store(string $tmpPath, string $destPath): bool
 {
     $dirPath = dirname($destPath);
     if (!file_exists($dirPath)) {
         mkdir($dirPath, 0755, true);
     }
     if (!move_uploaded_file($tmpPath, $destPath)) {
         throw new \RuntimeException('Failed to store the uploaded image.');
     }
     return true;

 }
}
