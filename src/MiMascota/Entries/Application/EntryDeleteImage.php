<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class EntryDeleteImage
{
    public function __construct(
        private EntryRepository $repository,
        private ImageRepository $imageRepository,
    ){}

    public function __invoke(string $entryId, string $imageId): bool
    {
        $entry = $this->repository->search($entryId);
        if ($entry === null) {
            throw new ModelNotFound("entry");
        }

        $image = $this->imageRepository->getFromEntryImage($imageId, $entryId);
        if ($image === null) {
            throw new ModelNotFound("image");
        }

        $response = unlink($image->getImage()->getPath());
        $entry->removeImage($image);
        $this->repository->save($entry);
        $this->imageRepository->remove($image->getImage());
        return $response;
    }
}
