<?php

namespace App\MessageHandler;

use App\Application\Actions\TelegramBot\TelegramBotMessage\SendTelegramBotMessageAction;
use App\Message\SendTelegramBotMessageMessage;
use App\Repository\TelegramBotMessageRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class SendTelegramBotMessageMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private TelegramBotMessageRepository $telegramBotMessageRepository,
        private SendTelegramBotMessageAction $sendTelegramBotMessage
    ){}

    public function __invoke(SendTelegramBotMessageMessage $message)
    {
        try {
            $tgMessage = $this->telegramBotMessageRepository->findOneBy(['id' => $message->getMessageId()]);

            if (is_null($tgMessage)) {
                throw new Exception(sprintf('TelegramBotMessage[id: %s] not found', $message->getMessageId()));
            }

            $this->sendTelegramBotMessage->execute($tgMessage);

        } catch (Throwable $e) {
            $this->logger->error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }
}
