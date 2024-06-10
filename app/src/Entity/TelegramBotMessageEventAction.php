<?php

namespace App\Entity;

use App\Repository\TelegramBotMessageEventActionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelegramBotMessageEventActionRepository::class)]
#[ORM\Index(fields: ['telegramBotMessage', 'event', 'action'])]
class TelegramBotMessageEventAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'telegramBotMessageEventActions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TelegramBotMessage $telegramBotMessage = null;

    #[ORM\Column(length: 100)]
    private ?string $event = null;

    #[ORM\Column(length: 100)]
    private ?string $action = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelegramBotMessage(): ?TelegramBotMessage
    {
        return $this->telegramBotMessage;
    }

    public function setTelegramBotMessage(?TelegramBotMessage $telegramBotMessage): static
    {
        $this->telegramBotMessage = $telegramBotMessage;

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(string $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }
}
