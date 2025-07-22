<?php

namespace App\MiMascota\Shared;

final readonly class SlugGenerator
{
    public static function generate(string $text): string
    {
        // Convert to lowercase
        $text = mb_strtolower($text);

        // Replace non-alphanumeric characters with hyphens
        $text = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);

        // Trim hyphens from the beginning and end
        $text = trim($text, '-');

        // Remove duplicate hyphens
        $text = preg_replace('/-+/', '-', $text);

        return $text;
    }

}
