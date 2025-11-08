<?php

namespace App\Console\Commands;

use App\Services\Kafka\ProducerService;
use App\Services\Kafka\Topics\AuditAuthV1\Enums\AuthTopicsEnum;
use App\Services\Kafka\Topics\AuditAuthV1\Message\AuditAuthMessage;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

class KafkaProducerAuditRecoveryCommand extends Command
{
    protected $signature = 'kafka-producer:audit-recovery-v1';

    protected $description = 'Produz mensagens de auditoria de login';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $accountUuid = Uuid::uuid7();
        $auditMessage = new AuditAuthMessage(
            eventId: Ulid::generate(),
            userName: fake()->name(),
            action: 'recovery',
            timestamp: now(),
            ipAddress: fake()->ipv4(),
            userAgent: fake()->userAgent(),
            accountUuid: $accountUuid
        );

        $return = new ProducerService(AuthTopicsEnum::AUDIT_RECOVERY_V1->value, $auditMessage->getMessage())->execute();
        $this->info(json_encode($return));
    }
}
