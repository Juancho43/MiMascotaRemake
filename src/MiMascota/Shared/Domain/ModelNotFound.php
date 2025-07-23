<?php

namespace App\MiMascota\Shared\Domain;

class ModelNotFound extends \DomainException
{
    public function __construct($model, $by = null, $value = null)
    {
        $message = "Model not found: {$model}";
        if ($by !== null && $value !== null) {
            $message .= " by {$by} with value {$value}";
        }
        parent::__construct($message);
    }

}
