<?php

namespace App\MiMascota\Reports\Application\Command;

class CreateReportCommand
{
    public function __construct(
        public string $reporterUserId,
        public string $reportedPostId,
        public string $reason,
        public string $status,

    )
    {

    }
}
