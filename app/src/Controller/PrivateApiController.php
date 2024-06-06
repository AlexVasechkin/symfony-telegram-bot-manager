<?php

namespace App\Controller;

use App\Message\SaveTelegramBotMessageMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class PrivateApiController extends AbstractController
{
    #[Route('/api/private/telegram-bot/save-response', methods: ['POST'])]
    public function saveTelegramBotResponse(Request $httpRequest, MessageBusInterface $messageBus): Response
    {
        $messageBus->dispatch(new SaveTelegramBotMessageMessage($httpRequest->getContent()));
        return new Response('ok');
    }
}
