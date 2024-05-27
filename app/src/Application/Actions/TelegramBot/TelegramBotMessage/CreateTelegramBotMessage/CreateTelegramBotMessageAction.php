<?php

namespace App\Application\Actions\TelegramBot\TelegramBotMessage\CreateTelegramBotMessage;

use App\Application\Contracts\TelegramBot\CreateTelegramBotMessageDTOInterface;
use App\Entity\TelegramBotMessage;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class CreateTelegramBotMessageAction
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){}

    public function execute(CreateTelegramBotMessageDTOInterface $args): TelegramBotMessage
    {
        $messageId = $args->getTelegramBotMessageData()['message_id'] ?? null;

        $telegramBotMessageRepository = $this->entityManager->getRepository(TelegramBotMessage::class);

        $telegramBotMessage = $telegramBotMessageRepository->findOneBy(['messageId' => $messageId]);

        if ($telegramBotMessage) {
            throw new Exception(sprintf('Message[message_id: %s] exists.', $messageId));
        }

        $telegramBotMessage = (new TelegramBotMessage())
            ->setProcessed(false)
            ->setMessageId($messageId)
            ->setData($args->getTelegramBotMessageData())
            ->setCreatedAt(new DateTime())
        ;

        $this->entityManager->persist($telegramBotMessage);
        $this->entityManager->flush();

        return $telegramBotMessage;
    }
}
