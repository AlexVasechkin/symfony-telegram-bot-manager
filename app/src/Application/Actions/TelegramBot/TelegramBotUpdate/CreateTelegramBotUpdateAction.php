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

    private function setChatIdFromMessage(TelegramBotUpdate $update): void
    {
        $chatId = (($update->getData()['message'] ?? [])['from'] ?? [])['id'] ?? 0;
        is_int($chatId) || $chatId = 0;
        $update->setChatId($chatId);
    }

    private function setChatIdFromCallbackQuery(TelegramBotUpdate $update): void
    {
        $chatId = (($update->getData()['callback_query'] ?? [])['from'] ?? [])['id'] ?? 0;
        is_int($chatId) || $chatId = 0;
        $update->setChatId($chatId);
    }

    private function setChatId(TelegramBotUpdate $update): void
    {
        if (TelegramBotUpdate::TYPE_MESSAGE === $update->getType()) {
            $this->setChatIdFromMessage($update);
        } elseif (TelegramBotUpdate::TYPE_CALLBACK_QUERY === $update->getType()) {
            $this->setChatIdFromCallbackQuery($update);
        } else {
            $update->setChatId(0);
        }
    }

    private function setPayloadFromMessage(TelegramBotUpdate $update): void
    {
        $payload = ($update->getData()['message'] ?? [])['text'] ?? '';
        is_string($payload) || $payload = '';
        $update->setPayload($payload);
    }

    private function setPayloadFromCallbackQuery(TelegramBotUpdate $update): void
    {
        $payload = ($update->getData()['callback_query'] ?? [])['data'] ?? '';
        is_string($payload) || $payload = '';
        $update->setPayload($payload);
    }

    private function setPayload(TelegramBotUpdate $update): void
    {
        if (TelegramBotUpdate::TYPE_MESSAGE === $update->getType()) {
            $this->setPayloadFromMessage($update);
        } elseif (TelegramBotUpdate::TYPE_CALLBACK_QUERY === $update->getType()) {
            $this->setPayloadFromCallbackQuery($update);
        } else {
            $update->setPayload(null);
        }
    }

    public function execute(CreateTelegramBotUpdateDTOInterface $args): TelegramBotUpdate
    {
        $updateId = $args->getTelegramBotUpdateData()['update_id'] ?? null;

        $update = $this->entityManager->getRepository(TelegramBotUpdate::class)->findOneBy(['id' => $updateId]);
        if ($update) {
            throw new Exception(sprintf('Update[id: %s] already exists', $updateId));
        }

        $update = (new TelegramBotUpdate())
            ->setId($updateId)
            ->setType($this->getType($args))
            ->setData($args->getTelegramBotUpdateData())
            ->setCreatedAt(new DateTime())
        ;

        $this->setChatId($update);

        $this->setPayload($update);

        $this->entityManager->persist($update);
        $this->entityManager->flush();

        return $update;
    }
}
