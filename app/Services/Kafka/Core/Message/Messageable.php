<?php

namespace App\Services\Kafka\Core\Message;

use Junges\Kafka\Message\Message;

interface Messageable
{
    public function getMessage(): Message;
}
