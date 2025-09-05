<?php

namespace App\Commands;

use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Application\ForumCreator;
use App\MiMascota\Forums\Application\ForumGetBySlug;
use App\MiMascota\Users\Domain\UserRepository;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:get-forum', description: 'Get a new forum')]
class GetForumDataCommand extends Command
{
    public function __construct(private ForumGetBySlug $forumGetData
    )
    {
        parent::__construct();
    }
    public function __invoke(
        OutputInterface $output,
        #[Argument('The slug of the forum')]
        string $slug,

    ): int
    {
        $output->writeln('Getting forum...');

        try {
        $response = ForumResponse::generate($this->forumGetData->__invoke($slug));

            $output->writeln('Forum retrieved successfully!');
            $output->writeln(sprintf('Forum ID: %s', $response['id']));
            $output->writeln(sprintf('Forum Name: %s', $response['name']));
            $output->writeln(sprintf('Forum Slug: %s', $response['slug']));
            $output->writeln(sprintf('Forum Description: %s', $response['description']));



        return Command::SUCCESS;

        }catch (\Exception $e) {
            $output->writeln(sprintf('Error: %s', $e->getMessage()));
            return Command::FAILURE;
        }

    }

}
