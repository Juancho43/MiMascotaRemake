<?php

namespace App\MiMascota\Reports\Application\DTO;

class ReportResponseCollection
{
    public static function generate(array $data) : array
    {
        $response = [];
        foreach ($data as $report) {
            $response[] = ReportResponse::generate($report);
        }
        return $response;
    }
}
