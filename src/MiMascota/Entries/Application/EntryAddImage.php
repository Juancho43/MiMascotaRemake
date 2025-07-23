<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\EntryImage;
use App\MiMascota\Shared\Domain\ModelNotFound;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EntryAddImage
{

    public function __construct(
        private SaveImage       $saveImage,
        private EntryRepository $entryRepository,
    )
    {

    }

    public function __invoke(
        UploadedFile $imageFile,
        string $entryid,
        int $position
    ): ?string
{
        $entry = $this->entryRepository->search($entryid);
        if ($entry === null){
            throw new ModelNotFound($entry,'id',$entryid);
        }
        $image = $this->saveImage->__invoke(
            $imageFile,
            'entry',
            $entryid,
        );
        $entryImage = EntryImage::create(Uuid::uuid4()->toString(),$entry,$image,$position);
        $entry->addImage($entryImage);
        $this->entryRepository->save($entry);
        return $image->getPath();
    }
}
