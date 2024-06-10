<?php

namespace App\Application\Contracts\TelegramBot;

interface CreateTelegramBotMessageDTOInterface extends GetChatIdInterface
{
    public function getData(): array;

    public function getType(): string;

    public function getUpdateId(): ?int;

    public function getPriority(): ?int;

    public function getActions(): array;
}
