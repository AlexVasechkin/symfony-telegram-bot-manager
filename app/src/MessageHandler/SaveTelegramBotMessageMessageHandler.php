<?php

namespace App\MessageHandler;

use App\Application\Actions\TelegramBot\TelegramBotMessage\CreateTelegramBotMessageAction;
use App\Message\SaveTelegramBotMessageMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class SaveTelegramBotMessageMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private CreateTelegramBotMessageAction $createTelegramBotMessage
    ){}

    public function __invoke(SaveTelegramBotMessageMessage $message)
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
