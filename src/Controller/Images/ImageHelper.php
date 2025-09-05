<?php

namespace App\Controller\Images;

use Symfony\Component\HttpFoundation\Request;

class ImageHelper
{
    public static function extractFormData(Request $request): array
    {
        return $request->request->all();
    }

    public static function extractUploadedFile(Request $request)
    {
        return $request->files->get('image');
    }
}
