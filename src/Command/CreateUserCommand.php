<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user

        $formatter = $this->getHelper('formatter');

        $formattedLine = $formatter->formatSection(
            'SomeSection',
            'Here is some message related to that section'
        );

        $output->writeln($formattedLine);

        $formattedLine = $formatter->formatSection(
            'SomeSection 22',
            'dotoooon',
            'error'
        );

        $output->writeln($formattedLine);
        $output->writeln("");


        $errorMessages = ['Error!', 'Something went wrong'];
        // 3ème param pour un plus grand padding
        $formattedBlock = $formatter->formatBlock($errorMessages, 'error', true);
        $output->writeln($formattedBlock);

        $message = "This is a very long message, which should be truncated";
        $truncatedMessage = $formatter->truncate($message, 7);
        $output->writeln($truncatedMessage);

        $helper = $this->getHelper('process');
        // premier paramètre du construct un array composé en première position de la commande a éxecuter et ennsuite arguments et/ou options
        $process = new Process(['ls', '--all']);

        $helper->run($output, $process);

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}