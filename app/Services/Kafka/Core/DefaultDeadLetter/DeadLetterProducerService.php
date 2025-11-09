<?php

namespace App\Services\Kafka\Core\DefaultDeadLetter;

use App\Services\Kafka\Enums\AuthTopicsEnum;
use Junges\Kafka\Facades\Kafka;

class DeadLetterProducerService
{
    public static function sendToDLQ(
        string $topic,
        array $payload,
        string $key,
        array $headers = []
    ): true {
        $broker ??= config('kafka.brokers');
        $kafka = Kafka::publish(broker: $broker)
            ->onTopic(topic: AuthTopicsEnum::DEAD_LETTER_QUEUE->value)
            ->withBodyKey(key: 'original_topic', message: $topic)
            ->withBodyKey(key:'payload', message: $payload)
            ->withBodyKey(key: 'key', message: $key);
        if (!empty($headers)) {
            $kafka->withBodyKey(key: 'headers', message: $headers);
        }
        $kafka->send();

        return true;
    }
}
