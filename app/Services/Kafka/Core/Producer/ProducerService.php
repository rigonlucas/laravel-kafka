<?php

namespace App\Services\Kafka\Core\Producer;

use App\Jobs\Kafka\AsyncProcessMessageJob;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

final class ProducerService
{
    public function __construct(
        private readonly string $topic,
        private readonly Message $message,
        private ?string $broker = null
    ) {
        $this->broker ??= config('kafka.brokers');
    }

    /**
     * @throws \Exception
     */
    public function executeSync(): bool
    {
        $builder = $this->resolvePublisher($this->broker)
            ->withMessage(message: $this->message)
            ->onTopic(topic: $this->topic);
        return $builder->send();
    }

    /**
     * Em caso de falha na publicação síncrona, tenta publicar de forma assíncrona.
     */
    public function execute(): bool
    {
        try {
            return $this->executeSync();
        } catch (\Exception $e) {
            $this->reportKafkaError(syncError: $e);
            return $this->dispatchEventAsync();
        }
    }

    private function dispatchEventAsync(): bool
    {
        AsyncProcessMessageJob::dispatch(topic: $this->topic, message: $this->message, broker: $this->broker);

        return true;
    }

    /**
     * @return \Junges\Kafka\Contracts\MessageProducer
     */
    private function resolvePublisher(mixed $broker, bool $async = false): mixed
    {
        if ($async) {
            return Kafka::publishAsync(broker: $broker);
        }

        return Kafka::publish(broker: $broker);
    }

    private function reportKafkaError(?\Exception $syncError): void
    {
        Log::error('Failed to publish Kafka message even via async fallback.', [
            'topic' => $this->topic,
            'broker' => $this->broker,
            'sync_error' => $syncError?->getMessage()
        ]);
    }
}
