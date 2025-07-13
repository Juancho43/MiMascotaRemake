<?php

namespace App\Controller\Entries;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EntryChangeImageController extends AbstractController
{

    #[Route('/entry/change/image/', name: 'entry_change_image', methods: ['POST'])]
    public function __invoke()
    {

    }
}
