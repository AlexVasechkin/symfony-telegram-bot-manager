<?php

namespace App\Application\Actions\TelegramBot\TelegramBotMessage;

use App\Entity\TelegramBotMessage;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\Message;
use Throwable;

class SendTelegramBotMessageAction
{
    public function __construct(
        private BotApi $botApi,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    ){}

    public function getReplyMarkup(TelegramBotMessage $message): ?InlineKeyboardMarkup
    {
        $replyMarkupData = $message->getData()['reply_markup'] ?? [];
        $inlineKeyboard = $replyMarkupData['inline_keyboard'] ?? null;

        $replyMarkup = null;
        if (is_array($inlineKeyboard)) {
            $replyMarkup = new InlineKeyboardMarkup($inlineKeyboard);
        }

        return $replyMarkup;
    }

    private function sendMessage(TelegramBotMessage $message): Message
    {
        $text = $message->getData()['text'] ?? '';
        if (!is_string($text) || (strlen($text) === 0)) {
            throw new Exception('Message text is empty.');
        }

        return $this->botApi->sendMessage(
            $message->getChatId(),
            $text,
            parseMode: $message->getData()['parse_mode'] ?? null,
            replyMarkup: $this->getReplyMarkup($message)
        );
    }

    public function sendPhoto(TelegramBotMessage $message): Message
    {
        return $this->botApi->sendPhoto(
            $message->getChatId(),
            ($message->getData()['photo'] ?? [])['url'] ?? '',
            caption: $message->getData()['text'] ?? '',
            replyMarkup: $this->getReplyMarkup($message),
            parseMode: $message->getData()['parse_mode'] ?? null,
        );
    }

    public function execute(TelegramBotMessage $message): void
    {
        try {
            if (TelegramBotMessage::TYPE_MESSAGE === $message->getType()) {
                $this->sendMessage($message);
            } elseif (TelegramBotMessage::TYPE_PHOTO === $message->getType()) {
                $this->sendPhoto($message);
            }
        } finally {
            $this->entityManager->persist($message->setSent(true));
            $this->entityManager->flush();
        }
    }
}
