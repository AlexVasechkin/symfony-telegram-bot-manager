<?php

namespace App\MessageHandler;

use App\Application\Actions\TelegramBot\TelegramBotUpdate\CreateTelegramBotUpdateAction;
use App\Message\SaveTelegramBotUpdateMessage;
use App\Message\SayNewTelegramBotUpdateMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

#[AsMessageHandler]
final class SaveTelegramBotUpdateMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private CreateTelegramBotUpdateAction $createTelegramBotUpdate,
        private MessageBusInterface $messageBus
    ){}

    public function __invoke(SaveTelegramBotUpdateMessage $message)
    {
        try {
            $update = $this->createTelegramBotUpdate->execute($message);

            $this->messageBus->dispatch(new SayNewTelegramBotUpdateMessage(json_encode($update->getData())));

        } catch (Throwable $e) {
            $this->logger->error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }
}
