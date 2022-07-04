<?php

namespace App\MessageHandler;

use App\Message\OrderChangeStatusMessage;
use App\Message\OrderMessage;
use App\Message\SendOrderMessage;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class SendOrderMessageHandler
{
    public function __construct(
        private ?LoggerInterface      $logger = null,
        private ParameterBagInterface $parameterBag
    )
    {
    }

    public function __invoke(SendOrderMessage $sendOrderMessage)
    {
        $this->logger->info('Order change status', ['orderId' => $sendOrderMessage->getId()]);
        $client = new Client(['base_uri' => $this->parameterBag->get("logistics_url")]);
        try {
            $request = $client->request('POST', $this->parameterBag->get("logistics_url"), [
                'json' => ['id' => $sendOrderMessage->getId(), 'volume' => $sendOrderMessage->getVolume(), 'weight' => $sendOrderMessage->getWeigth()]
            ]);
            $this->logger->info('Send to logistics', ['orderId' => $sendOrderMessage->getId()]);
        } catch (GuzzleException $e) {
            $this->logger->error('Error', ['message' => $e->getMessage()]);

        }
    }
}