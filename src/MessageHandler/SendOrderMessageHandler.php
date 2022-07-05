<?php

namespace App\MessageHandler;

use App\Message\SendOrderMessage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendOrderMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private ?LoggerInterface      $logger = null
    )
    {
    }

    public function __invoke(SendOrderMessage $sendOrderMessage)
    {
        $client = new Client(['base_uri' => $this->parameterBag->get("logistics_url")]);
        try {
            $request = $client->request('POST', $this->parameterBag->get("logistics_url"), [
                'json' => ['id' => $sendOrderMessage->id, 'volume' => $sendOrderMessage->volume, 'weight' => $sendOrderMessage->weight]
            ]);
            $this->logger->info('Send to logistics', ['orderId' => $sendOrderMessage->id]);
        } catch (GuzzleException $e) {
            $this->logger->error('Error', ['message' => $e->getMessage()]);

        }
    }
}