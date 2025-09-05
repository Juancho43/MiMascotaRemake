<?php

namespace App\MiMascota\Posts\Domain\ValueObject;



class PostReported
{
   private function __construct(private ?\DateTime $reportedAt)
   {

   }


   public static function create(?string $reportedAt): self
   {
         if($reportedAt === null){
              return new self(null);
         }
         return new self(new \DateTime($reportedAt));
   }
    public function getValue(): ?\DateTime
    {
        return $this->reportedAt;
    }

    public function __toString(): string
    {
        return $this->reportedAt ? $this->reportedAt->format('Y-m-d') : '';
    }
}
