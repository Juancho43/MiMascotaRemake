<?php

namespace App\MiMascota\Forums\Application\Command;

class CreateForumCommand
{
public function __construct(
    public string $name,
    public string $description,
)
{

}
}
