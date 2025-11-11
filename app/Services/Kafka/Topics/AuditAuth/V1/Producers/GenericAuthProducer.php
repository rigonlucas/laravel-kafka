<?php

namespace App\Services\Kafka\Topics\AuditAuth\V1\Producers;

use App\Services\Kafka\Core\Message\Messageable;
use App\Services\Kafka\Core\Producer\ProducerService;
use App\Services\Kafka\Enums\TopicsEnum;

class GenericAuthProducer
{
    public function execute(Messageable $auditMessage, TopicsEnum $authTopicsEnum): bool
    {
        return new ProducerService(topic: $authTopicsEnum->value, message: $auditMessage->getMessage())->execute();
    }
}
