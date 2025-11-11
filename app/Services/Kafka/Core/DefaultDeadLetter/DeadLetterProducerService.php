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
        Kafka::publish(broker: $broker)
            ->onTopic(topic: AuthTopicsEnum::AUTH_DEAD_LETTER_QUEUE->value)
            ->withBodyKey(key: 'original_topic', message: $topic)
            ->withBodyKey(key:'payload', message: $payload)
            ->withBodyKey(key: 'key', message: $key)
            ->withBodyKey(key: 'headers', message: $headers)
            ->send();

        return true;
    }
}
