<?php

namespace App\Services\Kafka;

use Junges\Kafka\Facades\Kafka;

readonly class ConsumerService
{
    private mixed $kafka;

    public function __construct(
        private array $topics,
        private string $consumerGroupId,
        private MessageHandlerInterface $messageHandler
    ) {
        $this->kafka = Kafka::consumer($this->topics)
            ->withBrokers('broker')
            ->withConsumerGroupId($this->consumerGroupId)
            ->withHandler($this->messageHandler)
            ->build();
    }

    public function execute(): void
    {
        $this->kafka->consume();
    }
}
