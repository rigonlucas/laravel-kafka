<?php

namespace App\Services\Kafka\Core;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

readonly class ProducerService
{
    private mixed $kafka;
    public function __construct(private string $topic, private Message $message)
    {
        $this->kafka = Kafka::publish(broker: 'broker')
            ->withMessage($this->message)
            ->onTopic($this->topic);
    }

    /**
     * @throws \Exception
     */
    public function execute(): bool
    {
        return $this->kafka->send();
    }
}
