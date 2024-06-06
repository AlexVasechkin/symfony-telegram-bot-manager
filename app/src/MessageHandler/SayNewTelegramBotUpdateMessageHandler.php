<?php

namespace App\MessageHandler;

use App\Message\SayNewTelegramBotUpdateMessage;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

#[AsMessageHandler]
final class SayNewTelegramBotUpdateMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private ParameterBagInterface $parameterBag,
        private HttpClientInterface $httpClient,
    ){}

    public function __invoke(SayNewTelegramBotUpdateMessage $message)
    {
        try {
            $httpListenerParameters = $this->parameterBag->get('app.bot')['http'] ?? [];

            $uri = ($httpListenerParameters['host'] ?? '') . ($httpListenerParameters['route'] ?? '');
            $headers = $httpListenerParameters['headers'] ?? [];

            $response = $this->httpClient->request('POST', $uri, [
                'headers' => $headers,
                'json' => $message->getData()
            ]);

            if (200 !== $response->getStatusCode()) {
                throw new Exception(sprintf('Http listener returned %s', $response->getStatusCode()));
            }

        } catch (Throwable $e) {
            $this->logger->error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }
}
