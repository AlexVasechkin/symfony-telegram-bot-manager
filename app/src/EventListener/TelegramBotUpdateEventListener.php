<?php

namespace App\EventListener;

use App\Message\SaveTelegramBotMessage;
use BoShurik\TelegramBotBundle\Event\UpdateEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\MessageBusInterface;

final class TelegramBotUpdateEventListener
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {}

    #[AsEventListener(event: UpdateEvent::class)]
    public function onUpdateEvent(UpdateEvent $event): void
    {
        $this->messageBus->dispatch(new SaveTelegramBotMessage($event->getUpdate()->getMessage()->toJson()));
    }
}
