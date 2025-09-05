<?php

namespace App\Commands;

use App\MiMascota\Forums\Application\ForumCreator;
use App\MiMascota\Users\Domain\UserRepository;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:create-forum', description: 'Create a new forum')]
class CreateForumCommand extends Command
{
    public function __construct(private ForumCreator $forumCreator,private UserRepository $userRepository
    )
    {
        parent::__construct();
    }
    public function __invoke(
        OutputInterface $output,
        #[Argument('The name of the forum')]
        string $name,
        #[Argument('The description of the forum')]
        string $description,
        #[Argument('The ID of the user creating the forum')]
        string $userId
    ): int
    {
        $output->writeln('Creating a new forum...');
        $output->writeln(sprintf('Name: %s', $name));
        $output->writeln(sprintf('Description: %s', $description));
        try {
        $user = $this->userRepository->search($userId);
            $response = $this->forumCreator->__invoke(
            name: $name,
            description: $description,
            user: $user
        );
        $output->writeln('Forum created successfully!');
            $output->writeln(sprintf('Forum ID: %s', $response['id']));
            $output->writeln(sprintf('Forum Name: %s', $response['name']));
            $output->writeln(sprintf('Forum Slug: %s', $response['slug']));
            $output->writeln(sprintf('Forum Description: %s', $response['description']));
            $output->writeln(sprintf('Created by User ID: %s', $userId));

        return Command::SUCCESS;

        }catch (\Exception $e) {
            $output->writeln(sprintf('Error: %s', $e->getMessage()));
            return Command::FAILURE;
        }

    }

}
