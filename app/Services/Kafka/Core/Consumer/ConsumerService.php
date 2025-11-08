<?php

namespace App\Services\Kafka\Core\Consumer;

use Carbon\Exceptions\Exception;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;

readonly class ConsumerService
{
    private mixed $kafka;

    public function __construct(
        private array $topics,
        private string $consumerGroupId,
        private ConsumerMessageHandler $messageHandler,
        string $broker = 'broker',
    ) {
        $this->kafka = Kafka::consumer(topics: $this->topics)
            ->withBrokers(brokers: $broker)
            ->withConsumerGroupId(groupId: $this->consumerGroupId)
            ->withHandler(handler: $this->messageHandler)
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
