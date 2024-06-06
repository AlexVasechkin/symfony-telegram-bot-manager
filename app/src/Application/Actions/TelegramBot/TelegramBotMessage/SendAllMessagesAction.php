<?php

namespace App\Application\Actions\TelegramBot\TelegramBotMessage;

use App\Entity\TelegramBotMessage;
use App\Repository\TelegramBotMessageRepository;
use Psr\Log\LoggerInterface;
use Throwable;

class SendAllMessagesAction
{
    public function __construct(
        private TelegramBotMessageRepository $telegramBotMessageRepository,
        private SendTelegramBotMessageAction $sendTelegramBotMessage,
        private LoggerInterface $logger
    ){}

    private function reloadMessagesToSent(): array
    {
        return $this->telegramBotMessageRepository->getMessagesToSend(30);
    }

    private function sendMessage(TelegramBotMessage $message): void
    {   try {
            $this->sendTelegramBotMessage->execute($message);
        } catch (Throwable $e) {
            $this->logger->error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }

    public function execute(): void
    {
        do {
            foreach ($this->reloadMessagesToSent() as $message) {
                $this->sendMessage($message);
            }

            usleep(900_000);

        } while (true);
    }
}
