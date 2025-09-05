<?php

namespace App\MiMascota\Posts\Application\Command;

class ReportPostCommand
{
    public function __construct(
         public string $id,
    )
    {}
}
