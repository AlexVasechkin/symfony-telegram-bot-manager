<?php

namespace App\Entity;

use App\Repository\TelegramBotUpdateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelegramBotUpdateRepository::class)]
#[ORM\Index(name: 'ix__type', columns: ['type'])]
class TelegramBotUpdate
{
    public const TYPE_CALLBACK_QUERY = 'callback_query';

    public const TYPE_MESSAGE = 'message';

    public const TYPE_OTHER = 'other';

    #[ORM\Id]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToOne(mappedBy: 'telegramBotUpdate', cascade: ['persist'])]
    private ?TelegramBotUpdateResponse $telegramBotUpdateResponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTelegramBotUpdateResponse(): ?TelegramBotUpdateResponse
    {
        return $this->telegramBotUpdateResponse;
    }

    public function setTelegramBotUpdateResponse(TelegramBotUpdateResponse $telegramBotUpdateResponse): static
    {
        // set the owning side of the relation if necessary
        if ($telegramBotUpdateResponse->getTelegramBotUpdate() !== $this) {
            $telegramBotUpdateResponse->setTelegramBotUpdate($this);
        }

        $this->telegramBotUpdateResponse = $telegramBotUpdateResponse;

        return $this;
    }
}
