<?php

namespace App\Entity;

use App\Repository\TelegramBotMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelegramBotMessageRepository::class)]
#[ORM\Index(columns: ['type'])]
#[ORM\Index(columns: ['chat_id'])]
#[ORM\Index(columns: ['created_at'])]
#[ORM\Index(columns: ['is_sent'])]
#[ORM\Index(columns: ['priority'])]
#[ORM\Index(columns: ['message_id'])]
class TelegramBotMessage
{
    public const TYPE_MESSAGE = 'message';
    public const TYPE_PHOTO = 'photo';

    public const PRIORITY_LOW = 60;
    public const PRIORITY_NORMAL = 50;
    public const PRIORITY_HIGH = 40;
    public const PRIORITY_IMMEDIATE = 30;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $chatId = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $isSent = false;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $priority = null;

    #[ORM\OneToOne(mappedBy: 'telegramBotMessage', cascade: ['persist'])]
    private ?TelegramBotUpdateResponse $telegramBotUpdateResponse = null;

    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true, 'default' => 0])]
    private ?string $messageId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatId(): ?int
    {
        return $this->chatId;
    }

    public function setChatId(int $chat_id): static
    {
        $this->chatId = $chat_id;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isSent(): ?bool
    {
        return $this->isSent;
    }

    public function setSent(bool $isSent): static
    {
        $this->isSent = $isSent;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getTelegramBotUpdateResponse(): ?TelegramBotUpdateResponse
    {
        return $this->telegramBotUpdateResponse;
    }

    public function setTelegramBotUpdateResponse(TelegramBotUpdateResponse $telegramBotUpdateResponse): static
    {
        // set the owning side of the relation if necessary
        if ($telegramBotUpdateResponse->getTelegramBotMessage() !== $this) {
            $telegramBotUpdateResponse->setTelegramBotMessage($this);
        }

        $this->telegramBotUpdateResponse = $telegramBotUpdateResponse;

        return $this;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function setMessageId(string $messageId): static
    {
        $this->messageId = $messageId;

        return $this;
    }
}
