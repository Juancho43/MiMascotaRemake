<?php

namespace App\MiMascota\Reports\Domain;

interface ReportRepository
{
    public function save(Report $reports) : void;
    public function findById(string $id) : ?Report;
    public function findAll(): array;
    public function findByForumAndLocation(string $forumSlug, string $locationSlug, int $page, int $limit): array;
    public function delete(Report $report): void;

}
