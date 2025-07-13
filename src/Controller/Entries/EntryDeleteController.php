<?php

namespace App\Controller\Entries;

use Symfony\Component\Routing\Annotation\Route;

class EntryDeleteController
{
    #[Route('/entry/delete', name: 'entry_delete', methods: ['DELETE'])]
    public function __invoke()
    {

    }
}
