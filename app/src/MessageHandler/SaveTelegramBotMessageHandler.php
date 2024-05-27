<?php

namespace App\MessageHandler;

use App\Application\Actions\TelegramBot\TelegramBotMessage\CreateTelegramBotMessage\CreateTelegramBotMessageAction;
use App\Message\SaveTelegramBotMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class SaveTelegramBotMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private CreateTelegramBotMessageAction $createTelegramBotMessage,
    ){}

    public function __invoke(SaveTelegramBotMessage $message)
    {
        try {
            $this->createTelegramBotMessage->execute($message);
        } catch (Throwable $e) {
            $this->logger->error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }
}
