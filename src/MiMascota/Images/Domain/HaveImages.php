<?php

namespace App\MiMascota\Images\Domain;

class HaveImages extends \DomainException
{
    public function __construct($model , $max)
    {
        parent::__construct('The ' . $model . ' cannot have more than '.$max.' images.');
    }
}
