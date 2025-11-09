<?php

namespace App\Services\Kafka\Topics\AuditAuth\V1\Producers;

use App\Services\Kafka\Core\Producer\ProducerService;
use App\Services\Kafka\Enums\AuthTopicsEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Messages\AuditAccountRecoveryMessage;

class RecoveryAccountProducer
{
    public function execute(AuditAccountRecoveryMessage $auditMessage): bool
    {
        return new ProducerService(AuthTopicsEnum::AUDIT_RECOVERY_V1->value, $auditMessage->getMessage())->execute();
    }
}
