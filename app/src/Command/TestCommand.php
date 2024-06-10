<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:test',
    description: 'Command to test everything.',
)]
class TestCommand extends Command
{
    private MessageBusInterface $messageBus;

    private LoggerInterface $logger;

    public function __construct(
        MessageBusInterface $messageBus,
        LoggerInterface $logger
    ) {
        $this->messageBus = $messageBus;
        $this->logger = $logger;
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}
