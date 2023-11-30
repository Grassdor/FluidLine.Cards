<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Creates a new admin user.
 */
#[AsCommand(name: 'new:admin', description: 'Creates an admin.')]
class CreateUserCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $delimiter = "==================";
        $output->writeln($delimiter);
        $helper = $this->getHelper('question');

        $passwordRequired = new Question('Set user password: ', 'password');
        $password = $helper->ask($input, $output, $passwordRequired);
        $output->writeln($delimiter);

        $username = "admin";
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $fs = new Filesystem();

        try {
            $fs->appendToFile(".env", "USER_NAME='$username'\n");
            $fs->appendToFile(".env", "USER_PASS='$passwordHash'\n");
            $fs->appendToFile(".env", "USER_ROLE=ROLE_ADMIN\n");

        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }

        $output->writeln("New admin user created");
        $output->writeln("Username: ". $username ." -- Password: ". $password);

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to create a user...')
            ->setDescription('Creates a new admin user.')
        ;
    }
}