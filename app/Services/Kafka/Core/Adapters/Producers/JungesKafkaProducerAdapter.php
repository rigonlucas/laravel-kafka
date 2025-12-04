<?php

namespace App\Services\Kafka\Core\Adapters\Producers;

use Junges\Kafka\Contracts\MessageProducer as InternalProducer;
use Junges\Kafka\Message\Message;

class JungesKafkaProducerAdapter implements KafkaProducer
{

    public function __construct(private InternalProducer $producer) {}

    public function withMessage(Message $message): static
    {
        $this->producer->withMessage(message: $message);
        return $this;
    }

    public function onTopic(string $topic): static
    {
        $this->producer->onTopic(topic: $topic);
        return $this;
    }

    public function send(): bool
    {
        return $this->producer->send();
    }
}
