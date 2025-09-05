<?php

namespace App\MiMascota\Images\Domain;


use App\MiMascota\Forums\Domain\ValueObject\ForumImage;

interface ImageRepository
{
    public function search(string $id): ?Image;

    public function save(Image $image): void;

    public function remove(Image $image): void;

    public function getFromAnimalImage(string $id, string $animalId): ?AnimalImage;
    public function getFromEntryImage(string $id, string $entryId): ?EntryImage;
    public function getFromUserImage(string $id, string $userId): ?UserImage;
    public function getFromForumImage( string $forumId): ?ForumImage;
}
