<?php

namespace App\Message;

use App\Application\Contracts\TelegramBot\CreateTelegramBotUpdateDTOInterface;
use App\Application\Contracts\TelegramBot\GetTelegramBotUpdateDataInterface;

final class SaveTelegramBotUpdateMessage
    implements GetTelegramBotUpdateDataInterface,
               CreateTelegramBotUpdateDTOInterface
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

    public function getTelegramBotUpdateData(): array
    {
        return $this->getData();
    }
}
