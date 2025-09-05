<?php

namespace App\MiMascota\Reports\Application\Query;

class GetReportByIdQuery
{
    public function __construct(
        public readonly string $reportId,
    ) {
    }
}
