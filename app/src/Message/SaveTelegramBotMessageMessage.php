<?php

namespace App\Message;

use App\Application\Contracts\TelegramBot\CreateTelegramBotMessageDTOInterface;

final class SaveTelegramBotMessageMessage
    implements CreateTelegramBotMessageDTOInterface
{
    private array $data;

    private string $type;

    private ?int $chatId;

    private ?int $updateId;

    private ?int $priority;

    public function __construct(string $dataAsJson)
    {
        $decodedData = json_decode($dataAsJson, true, 512, JSON_THROW_ON_ERROR);
        $this->data = $decodedData['payload'] ?? [];
        $this->type = $decodedData['type'] ?? null;
        $this->chatId = $decodedData['chat_id'] ?? null;
        $this->updateId = $decodedData['update_id'] ?? null;
        $this->priority = $decodedData['priority'] ?? null;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getChatId(): ?int
    {
        return $this->chatId;
    }

    public function getUpdateId(): ?int
    {
        return $this->updateId;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }
}
