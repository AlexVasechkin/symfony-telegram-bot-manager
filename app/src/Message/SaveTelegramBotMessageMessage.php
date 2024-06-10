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

    private array $actions;

    public function __construct(string $dataAsJson)
    {
        file_put_contents(__dir__ . '/message.json', json_encode($dataAsJson, JSON_THROW_ON_ERROR));
        $decodedData = json_decode($dataAsJson, true, 512, JSON_THROW_ON_ERROR);
        $this->data = $decodedData['payload'] ?? [];
        $this->type = $decodedData['type'] ?? null;
        $this->chatId = $decodedData['chat_id'] ?? null;
        $this->updateId = $decodedData['update_id'] ?? null;
        $this->priority = $decodedData['priority'] ?? null;
        $this->actions = $decodedData['actions'] ?? null;
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

    public function getActions(): array
    {
        return $this->actions;
    }

    public function setActions(array $actions): self
    {
        $this->actions = $actions;
        return $this;
    }
}
