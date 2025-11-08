<?php

namespace App\Services\Kafka\Topics\AuditLoginV1\Consumer;

use App\Services\Kafka\MessageHandlerInterface;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

readonly class AuditLoginHandler implements MessageHandlerInterface
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): bool
    {
        return $this->process($message);
    }

    private function process(ConsumerMessage $message): bool
    {
        echo "Key: ";
        echo "\t" . $message->getKey() . PHP_EOL;
        echo "Body:" . PHP_EOL;
        foreach ($message->getBody() as $key => $value) {
            echo "\t $key: $value" . PHP_EOL;
        }
        echo "Headers:" . PHP_EOL;
        foreach ($message->getHeaders() as $key => $header) {
            echo "\t $key: $header" . PHP_EOL;
        }

        echo "---------------------------------" ;
        echo PHP_EOL;


        return true;
    }
}
