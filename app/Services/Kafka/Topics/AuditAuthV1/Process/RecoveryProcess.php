<?php

namespace App\Services\Kafka\Topics\AuditAuthV1\Process;

use Junges\Kafka\Contracts\ConsumerMessage;

class RecoveryProcess
{
    public static function process(ConsumerMessage $message): bool
    {
        echo "------------------- RECOVERY -----------------" . PHP_EOL;
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
