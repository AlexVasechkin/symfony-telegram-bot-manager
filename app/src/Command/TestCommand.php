<?php

namespace App\Command;

use App\Application\Actions\TelegramBot\TelegramBotMessage\SendAllMessagesAction;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use TelegramBot\Api\BotApi;

#[AsCommand(
    name: 'app:test',
    description: 'Command to test everything.',
)]
class TestCommand extends Command
{
    private BotApi $botApi;

    private MessageBusInterface $messageBus;

    private LoggerInterface $logger;

    public function __construct(
        BotApi $botApi,
        MessageBusInterface $messageBus,
        LoggerInterface $logger,
        private SendAllMessagesAction $sendAllMessagesAction
    ) {
        $this->botApi = $botApi;
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
