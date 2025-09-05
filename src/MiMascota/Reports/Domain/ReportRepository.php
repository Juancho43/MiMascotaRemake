<?php

namespace App\MiMascota\Reports\Domain;

interface ReportRepository
{
    public function save(Report $reports) : void;
    public function findById(string $id) : ?Report;
    public function findAll(): array;
    public function delete(Report $report): void;

}
