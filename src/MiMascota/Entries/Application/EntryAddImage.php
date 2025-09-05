<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\Command\CreateEntryImageCommand;
use App\MiMascota\Entries\Application\Query\EntryGetByIdQuery;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\EntryImage;
use App\MiMascota\Shared\Domain\ModelNotFound;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class EntryAddImage
{

    public function __construct(
        private SaveImage       $saveImage,
        private EntryRepository $entryRepository,
        private EntryGetById     $entryGetById,
    )
    {

    }

    public function __invoke(
        CreateEntryImageCommand $command
    ): EntryImage
{
        $entry = $this->entryGetById->__invoke(new EntryGetByIdQuery($command->entryId));
        $image = $this->saveImage->__invoke(
            $command->file,
            'entry',
            $command->entryId,
        );
        $entryImage = EntryImage::create(Uuid::uuid4()->toString(),$entry,$image,$command->position);
        $entry->addImage($entryImage);
        $this->entryRepository->save($entry);
        return $entryImage;
    }
}
