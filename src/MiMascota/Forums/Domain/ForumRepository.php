<?php

namespace App\MiMascota\Forums\Domain;

interface ForumRepository
{
    public function getBySlug(string $slug): ?Forum;
    public function search(string $id): ?Forum;

    public function save(Forum $forum): void;

    public function remove(Forum $forum): void;

}
