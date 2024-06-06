<?php

namespace App\Application\Actions\TelegramBot\TelegramBotUpdate;

use App\Application\Contracts\TelegramBot\CreateTelegramBotUpdateDTOInterface;
use App\Entity\TelegramBotUpdate;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class CreateTelegramBotUpdateAction
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){}

    private function getType(CreateTelegramBotUpdateDTOInterface $args): string
    {
        $keys = array_keys($args->getTelegramBotUpdateData());

        if (in_array(TelegramBotUpdate::TYPE_CALLBACK_QUERY, $keys)) {
            return TelegramBotUpdate::TYPE_CALLBACK_QUERY;
        } elseif (in_array(TelegramBotUpdate::TYPE_MESSAGE, $keys)) {
            return TelegramBotUpdate::TYPE_MESSAGE;
        } else {
            return TelegramBotUpdate::TYPE_OTHER;
        }
    }

    public function execute(CreateTelegramBotUpdateDTOInterface $args): TelegramBotUpdate
    {
        $updateId = $args->getTelegramBotUpdateData()['update_id'] ?? null;

        $update = $this->entityManager->getRepository(TelegramBotUpdate::class)->findOneBy(['id' => $updateId]);
        if ($update) {
            throw new Exception(sprintf('Update[id: %s] already exists', $updateId));
        }

        $type = $this->getType($args);

        $update = (new TelegramBotUpdate())
            ->setId($updateId)
            ->setType($type)
            ->setData($args->getTelegramBotUpdateData())
            ->setCreatedAt(new DateTime())
        ;

        $this->entityManager->persist($update);
        $this->entityManager->flush();

        return $update;
    }
}
