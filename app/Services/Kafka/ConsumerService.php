<?php

namespace App\Services\Kafka;

use Carbon\Exceptions\Exception;
use Junges\Kafka\Exceptions\ConsumerException;
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

    /**
     * @throws Exception
     * @throws ConsumerException
     */
    public function execute(): void
    {
        $this->kafka->consume();
    }
}
