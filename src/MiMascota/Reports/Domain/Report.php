<?php

namespace App\MiMascota\Reports\Domain;

use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Reports\Domain\ValueObject\ReportReason;
use App\MiMascota\Reports\Domain\ValueObject\ReportStatus;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\User;

class Report
{
    private TimeStamp $timeStamp;
    private function __construct(
        private readonly string $id,
        private Post $reportedPost,
        private User $reporterUser,
        private ReportReason $reason,
        private ReportStatus $status,

    ){
        $this->timeStamp = new TimeStamp();
    }

    public static function create(
        string $id,
        Post $reportedPost,
        User $reporterUser,
        ReportReason $reason,
        ReportStatus $status,

    ): self {
        return new self(
            $id,
            $reportedPost,
            $reporterUser,
            $reason,
            $status,

        );
    }
    public function getId() : string
    {
        return $this->id;
    }
    public function getTimeStamp(): TimeStamp
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(TimeStamp $timeStamp): void
    {
        $this->timeStamp = $timeStamp;
    }

    public function getReportedPost(): Post
    {
        return $this->reportedPost;
    }

    public function setReportedPost(Post $reportedPost): void
    {
        $this->reportedPost = $reportedPost;
    }

    public function getReporterUser(): User
    {
        return $this->reporterUser;
    }

    public function setReporterUser(User $reporterUser): void
    {
        $this->reporterUser = $reporterUser;
    }

    public function getReason(): ReportReason
    {
        return $this->reason;
    }

    public function setReason(ReportReason $reason): void
    {
        $this->reason = $reason;
    }

    public function getStatus(): ReportStatus
    {
        return $this->status;
    }

    public function setStatus(ReportStatus $status): void
    {
        $this->status = $status;
    }

}
