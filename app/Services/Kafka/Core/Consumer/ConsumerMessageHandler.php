<?php

namespace App\Services\Kafka\Core\Consumer;

use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

interface ConsumerMessageHandler
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): bool;
}
