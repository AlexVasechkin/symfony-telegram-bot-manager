<?php

namespace App\Application\Contracts\TelegramBot;

interface GetChatIdInterface
{
    public function getChatId(): ?int;
}
