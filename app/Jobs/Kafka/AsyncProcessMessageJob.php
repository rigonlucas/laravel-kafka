<?php

namespace App\Jobs\Kafka;

use App\Services\Kafka\Core\Producer\ProducerService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Junges\Kafka\Message\Message;

class AsyncProcessMessageJob implements ShouldQueue
{
    use Queueable;
    use InteractsWithQueue;
    use Dispatchable;

    public int $tries = 2;

    public function __construct(
        private readonly string $topic,
        private readonly Message $message,
        private readonly ?string $broker = null
    ) {
    }
    public function handle(): void
    {
        $kafkaProducerService = new ProducerService(
            topic: $this->topic,
            message: $this->message,
            broker: $this->broker
        );
        $kafkaProducerService->executeSync();
    }
}
