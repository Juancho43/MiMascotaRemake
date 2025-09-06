<?php

namespace App\MiMascota\Reports\Application\DTO;

use App\MiMascota\Reports\Domain\Report;

class ReportResponse
{
    public static function generate(Report $report) : array
    {
        return [
            'id' => $report->getId(),
            'reporter' => [
                'id' => $report->getReporterUser()->getId(),
                'name' => $report->getReporterUser()->getName(),
                'email' => $report->getReporterUser()->getEmail(),
            ],
            'reportedPost' => [
                'id' => $report->getReportedPost()->getId(),
                'title' => $report->getReportedPost()->getTitle(),
                'slug' => $report->getReportedPost()->getSlug(),
            ],
            'reason' => $report->getReason()->value(),
            'status' => $report->getStatus()->value(),
            'createdAt' => $report->getTimeStamp()?->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $report->getTimeStamp()->getUpdatedAt()?->format('Y-m-d H:i:s') ?? null ,
        ];
    }
}
