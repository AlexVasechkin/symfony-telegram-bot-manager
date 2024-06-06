<?php

namespace App\Message;

final class SayNewTelegramBotUpdateMessage
{
    private array $data;

    public function __construct(string $dataAsJson)
    {
        $this->data = json_decode($dataAsJson, true, 512, JSON_THROW_ON_ERROR);
    }

    public function getData(): array
    {
        return $this->data;
    }
}
