<?php

namespace App\Application\Actions\TelegramBot\TelegramBotMessage;

use App\Application\Contracts\TelegramBot\CreateTelegramBotMessageDTOInterface;
use App\Entity\TelegramBotMessage;
use App\Entity\TelegramBotUpdateResponse;
use App\Repository\TelegramBotUpdateRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class CreateTelegramBotMessageAction
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private TelegramBotUpdateRepository $telegramBotUpdateRepository,
    ){}

    public function execute(CreateTelegramBotMessageDTOInterface $args): TelegramBotMessage
    {
        $message = (new TelegramBotMessage())
            ->setType($args->getType())
            ->setChatId($args->getChatId())
            ->setData($args->getData())
            ->setCreatedAt(new DateTime())
            ->setPriority(TelegramBotMessage::PRIORITY_NORMAL)
        ;

        $this->entityManager->persist($message);

        if (is_int($args->getUpdateId())) {
            $update = $this->telegramBotUpdateRepository->findOneBy(['id' => $args->getUpdateId()]);
            if ($update) {
                $updateResponse = (new TelegramBotUpdateResponse())
                    ->setTelegramBotMessage($message)
                    ->setTelegramBotUpdate($update)
                ;

                $this->entityManager->persist($updateResponse);

                $message->setPriority(TelegramBotMessage::PRIORITY_HIGH);

                $this->entityManager->persist($message);
            }
        }

        if ($args->getPriority()) {
            $message->setPriority($args->getPriority());
            $this->entityManager->persist($message);
        }

        $this->entityManager->flush();

        return $message;
    }
}