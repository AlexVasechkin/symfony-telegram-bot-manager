<?php

namespace App\Entity;

use App\Repository\TelegramBotUpdateResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelegramBotUpdateResponseRepository::class)]
#[ORM\Index(fields: ['telegramBotUpdate', 'telegramBotMessage'])]
#[ORM\Index(fields: ['telegramBotMessage'])]
class TelegramBotUpdateResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'telegramBotUpdateResponse', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?TelegramBotUpdate $telegramBotUpdate = null;

    #[ORM\OneToOne(inversedBy: 'telegramBotUpdateResponse', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?TelegramBotMessage $telegramBotMessage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelegramBotUpdate(): ?TelegramBotUpdate
    {
        return $this->telegramBotUpdate;
    }

    public function setTelegramBotUpdate(TelegramBotUpdate $telegramBotUpdate): static
    {
        $this->telegramBotUpdate = $telegramBotUpdate;

        return $this;
    }

    public function getTelegramBotMessage(): ?TelegramBotMessage
    {
        return $this->telegramBotMessage;
    }

    public function setTelegramBotMessage(TelegramBotMessage $telegramBotMessage): static
    {
        $this->telegramBotMessage = $telegramBotMessage;

        return $this;
    }
}
