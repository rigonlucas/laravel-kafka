<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Junges\Kafka\Events\PublishingMessage;

class KafkaMessageInterceptor
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PublishingMessage $event): void
    {
        DB::table('kafka_fallback')->updateOrInsert(
            [
                'message_identifier' => $event->message->getMessageIdentifier(),
            ],
            [
                'topic' => $event->message->getTopicName(),
                'message_identifier' => $event->message->getMessageIdentifier(),
                'message' => json_encode($event->message->getBody()),
                'headers' => json_encode($event->message->getHeaders()),
                'key' => $event->message->getKey(),
                'created_at' => now(),
            ]
        );
    }
}
