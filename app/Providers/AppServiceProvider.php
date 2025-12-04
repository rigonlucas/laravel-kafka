<?php

namespace App\Providers;

use App\Listeners\KafkaAsyncMessagesInterceptor;
use App\Listeners\KafkaMessageInterceptor;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Junges\Kafka\Events\CouldNotPublishMessage;
use Junges\Kafka\Events\PublishingMessage;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            events: PublishingMessage::class,
            listener: KafkaMessageInterceptor::class,
        );
    }
}
