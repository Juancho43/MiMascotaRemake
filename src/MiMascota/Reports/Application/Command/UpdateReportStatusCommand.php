<?php

namespace App\MiMascota\Reports\Application\Command;

class UpdateReportStatusCommand
{
    public function __construct(
        public string $id,
        public string $status,

    )
    {

    }
}
