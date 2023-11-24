<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user.',
    hidden: false,
    aliases: ['app:add-user']
)]
class CreateUserCommand extends Command
{
    protected static $defaultDescription = 'Creates a new admin user.';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $unhashPassword = readline("Enter new password: " . PHP_EOL);
        $username = readline("Enter new username: " . PHP_EOL);
        $password = password_hash($unhashPassword, PASSWORD_DEFAULT);

        $fs = new Filesystem();
        try {
            $fs->appendToFile(".env", "USER_NAME=" . "'" . $username . "'" . PHP_EOL);
            $fs->appendToFile(".env", "USER_PASS=" . "'" . $password . "'" . PHP_EOL);
            $fs->appendToFile(".env", "USER_ROLE=" . "ROLE_ADMIN" . PHP_EOL);
            // dd($fs);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        };
        $output->writeln("New admin user created");
        $output->writeln("Username: " . $username);
        $output->writeln("Password: " . $unhashPassword);
        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to create a user...')
        ;
    }
}