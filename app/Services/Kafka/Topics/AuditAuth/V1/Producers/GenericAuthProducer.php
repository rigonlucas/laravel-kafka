<?php

namespace App\Services\Kafka\Topics\AuditAuth\V1\Producers;

use App\Services\Kafka\Core\Message\Messageable;
use App\Services\Kafka\Core\Producer\ProducerService;
use App\Services\Kafka\Enums\AuthTopicsEnum;

class GenericAuthProducer
{
    public function execute(Messageable $auditMessage, AuthTopicsEnum $authTopicsEnum): bool
    {
        return new ProducerService($authTopicsEnum->value, $auditMessage->getMessage())->execute();
    }
}
