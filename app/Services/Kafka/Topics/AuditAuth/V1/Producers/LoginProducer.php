<?php

namespace App\Services\Kafka\Topics\AuditAuth\V1\Producers;

use App\Services\Kafka\Core\Producer\ProducerService;
use App\Services\Kafka\Enums\AuthTopicsEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Messages\AuditAuthMessage;

class LoginProducer
{
    public function execute(AuditAuthMessage $auditMessage): bool
    {
        return new ProducerService(AuthTopicsEnum::AUDIT_LOGIN_V1->value, $auditMessage->getMessage())->execute();
    }
}
