<?php

namespace App\Controller\Entries;

use App\MiMascota\Entries\Domain\Entry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EntryEditController extends AbstractController
{
    #[Route('/entry/edit', name: 'entry_edit', methods: ['PUT'])]
    public function __invoke()
    {

    }
}
