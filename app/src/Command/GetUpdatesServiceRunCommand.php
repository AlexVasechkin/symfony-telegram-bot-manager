<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:get-updates:service:run',
    description: 'Command to get telegram updates every second',
)]
class GetUpdatesServiceRunCommand extends Command
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger,
    ) {
        $this->logger = $logger;
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $application = $this->getApplication();

            $application->setAutoExit(false);

            $input = new ArrayInput([
                'command' => 'telegram:updates',
            ]);

            $output = new NullOutput();

            do {
                $application->run($input, $output);

                usleep(900_000);

            } while (true);

            return Command::SUCCESS;

        } catch (Throwable $e) {
            $this->logger->error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString(),
            ]));

            return Command::FAILURE;
        }
    }
}
