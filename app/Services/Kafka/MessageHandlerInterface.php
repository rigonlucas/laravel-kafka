<?php

namespace App\Services\Kafka;

use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

interface MessageHandlerInterface
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): bool;
}
