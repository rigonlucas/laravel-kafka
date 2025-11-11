<?php

namespace App\Services\Kafka\Core\DefaultDeadLetter;

use App\Services\Kafka\Enums\TopicsEnum;
use Junges\Kafka\Facades\Kafka;

class DeadLetterProducerService
{
    /**
     * @throws \Exception
     */
    public static function sendToDLQ(
        string $topic,
        array $payload,
        string $key,
        TopicsEnum $authTopicsEnum,
        array $headers = []
    ): true {
        $broker ??= config('kafka.brokers');
        Kafka::publish(broker: $broker)
            ->onTopic(topic: $authTopicsEnum->value)
            ->withBodyKey(key: 'original_topic', message: $topic)
            ->withBodyKey(key:'payload', message: $payload)
            ->withBodyKey(key: 'key', message: $key)
            ->withBodyKey(key: 'headers', message: $headers)
            ->send();

        return true;
    }
}
