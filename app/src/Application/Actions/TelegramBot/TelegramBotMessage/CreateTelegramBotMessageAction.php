<?php

namespace App\Application\Actions\TelegramBot\TelegramBotMessage;

use App\Application\Contracts\TelegramBot\CreateTelegramBotMessageDTOInterface;
use App\Entity\TelegramBotMessage;
use App\Entity\TelegramBotMessageEventAction;
use App\Entity\TelegramBotUpdateResponse;
use App\Repository\TelegramBotUpdateRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

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
            ->setMessageId(0)
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

        try {
            foreach ($args->getActions() as $action) {
                $this->entityManager->persist(
                    (new TelegramBotMessageEventAction())
                        ->setTelegramBotMessage($message)
                        ->setEvent(sprintf('%s', $action['event'] ?? ''))
                        ->setAction(sprintf('%s', $action['action'] ?? ''))
                );
            }
        } catch (Throwable) {
            // do nothing
        } finally {
            $this->entityManager->flush();
        }

        return $message;
    }
}