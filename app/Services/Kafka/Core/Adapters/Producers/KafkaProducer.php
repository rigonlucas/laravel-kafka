<?php

namespace App\Services\Kafka\Core\Adapters\Producers;

use Junges\Kafka\Message\Message;

interface KafkaProducer
{
    public function withMessage(Message $message): static;
    public function onTopic(string $topic): static;
    public function send(): bool;
}
