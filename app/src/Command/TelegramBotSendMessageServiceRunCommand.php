<?php

namespace App\Command;

use App\Application\Actions\TelegramBot\TelegramBotMessage\SendAllMessagesAction;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:telegram-bot:send-message:service:run',
    description: 'Command to send messages to recipients',
)]
class TelegramBotSendMessageServiceRunCommand extends Command
{
    private LoggerInterface $logger;

    private SendAllMessagesAction $sendAllMessages;

    public function __construct(
        LoggerInterface $logger,
        SendAllMessagesAction $sendAllMessages
    ) {
        $this->logger = $logger;
        $this->sendAllMessages = $sendAllMessages;
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->sendAllMessages->execute();

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
