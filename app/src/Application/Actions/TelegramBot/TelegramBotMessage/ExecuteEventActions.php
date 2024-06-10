<?php

namespace App\Application\Actions\TelegramBot\TelegramBotMessage;

use App\Entity\TelegramBotUpdate;
use App\Repository\TelegramBotMessageRepository;
use Exception;
use Psr\Log\LoggerInterface;
use TelegramBot\Api\BotApi;
use Throwable;

class ExecuteEventActions
{
    public function __construct(
        private LoggerInterface $logger,
        private BotApi $botApi,
        private TelegramBotMessageRepository $telegramBotMessageRepository
    ){}

    public function execute(TelegramBotUpdate $update): void
    {
        if (TelegramBotUpdate::TYPE_CALLBACK_QUERY === $update->getType()) {
            $messageId = $update->getData()[TelegramBotUpdate::TYPE_CALLBACK_QUERY]['message']['message_id'];

            $message = $this->telegramBotMessageRepository->findOneBy(['messageId' => $messageId]);

            if (is_null($message)) {
                throw new Exception(sprintf('Message[message_id: %s] not found]', $messageId));
            }

            foreach ($message->getTelegramBotMessageEventActions()->toArray() as $eventAction) {
                try {
                    if (   (TelegramBotUpdate::TYPE_CALLBACK_QUERY === $eventAction->getEvent())
                        && ('delete' === $eventAction->getAction())
                    ) {
                        $this->botApi->deleteMessage($update->getChatId(), $messageId);
                    }
                } catch (Throwable $e) {
                    $this->logger->error(implode(PHP_EOL, [
                        $e->getMessage(),
                        $e->getTraceAsString()
                    ]));
                }
            }
        }
    }
}
