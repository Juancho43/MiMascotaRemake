<?php

namespace App\Tests\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\EntryGetManyPagination;
use App\MiMascota\Entries\Application\Query\EntryGetByJournalSlugPaginationQuery;
use App\MiMascota\Journals\Domain\JournalRepository;
use PHPUnit\Framework\TestCase;

class EntryGetManyPaginationTest extends TestCase
{
    private EntryGetManyPagination $entryGetManyPagination;
    private JournalRepository $journalRepository;
    public function setUp(): void
    {
        $this->journalRepository= $this->createMock(JournalRepository::class);
        $this->entryGetManyPagination = new EntryGetManyPagination($this->journalRepository);
    }
    public function test__invoke()
    {
        $this->journalRepository->expects($this->once())
            ->method('getEntries')
            ->with('journal-id', 1, 10)
            ->willReturn(['entry1', 'entry2']);
        $query = new EntryGetByJournalSlugPaginationQuery('journal-id', 1, 10);
        $response = $this->entryGetManyPagination->__invoke($query);
        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }
}
