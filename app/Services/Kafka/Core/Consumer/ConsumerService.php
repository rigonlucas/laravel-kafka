<?php

namespace App\Services\Kafka\Core\Consumer;

use App\Services\Kafka\Enums\ConsumerGroupEnum;
use App\Services\Kafka\Enums\TopicsEnum;
use Carbon\Exceptions\Exception;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;

readonly class ConsumerService
{
    private mixed $kafka;

    /**
     * @throws ConsumerException
     */
    public function __construct(
        private array $topics,
        private ConsumerGroupEnum $consumerGroup,
        private ConsumerMessageHandler $messageHandler,
        ?TopicsEnum $deadLetterTopic,
        ?string $broker = null,
    ) {
        $broker ??= config('kafka.brokers');
        $this->kafka = Kafka::consumer(topics: $this->topics)
            ->withBrokers(brokers: $broker)
            ->withConsumerGroupId(groupId: $this->consumerGroup->value)
            ->withHandler(handler: $this->messageHandler)
            ->withDlq(dlqTopic: $deadLetterTopic->value)
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
