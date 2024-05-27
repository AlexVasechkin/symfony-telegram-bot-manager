<?php

namespace App\Message;

use App\Application\Contracts\TelegramBot\CreateTelegramBotMessageDTOInterface;
use App\Application\Contracts\TelegramBot\GetTelegramBotMessageDataInterface;

final class SaveTelegramBotMessage
    implements GetTelegramBotMessageDataInterface,
               CreateTelegramBotMessageDTOInterface
{
    private array $data;

    public function __construct(string $dataAsJson)
    {
        $this->data = json_decode($dataAsJson, true);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getTelegramBotMessageData(): array
    {
        return $this->getData();
    }
}
