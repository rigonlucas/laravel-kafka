<?php

namespace App\Services\Kafka\Core\Producer;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

readonly class ProducerService
{
    private mixed $kafka;
    public function __construct(private string $topic, private Message $message, ?string $broker = null)
    {
        $broker ??= config('kafka.brokers');
        $this->kafka = Kafka::publish(broker: $broker)
            ->withMessage(message: $this->message)
            ->onTopic(topic: $this->topic);
    }

    /**
     * @throws \Exception
     */
    public function execute(): bool
    {
        return $this->kafka->send();
    }
}
