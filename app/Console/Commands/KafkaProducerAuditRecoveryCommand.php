<?php

namespace App\Console\Commands;

use App\Services\Kafka\Topics\AuditAuth\V1\Messages\AuditAccountRecoveryMessage;
use App\Services\Kafka\Topics\AuditAuth\V1\Producers\RecoveryAccountProducer;
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
        $auditMessage = new AuditAccountRecoveryMessage(
            eventId: Ulid::generate(),
            email: fake()->email(),
            action: 'recovery',
            timestamp: now(),
            ipAddress: fake()->ipv4(),
            userAgent: fake()->userAgent(),
            accountUuid: $accountUuid
        );

        $return = new RecoveryAccountProducer()->execute($auditMessage);
        $this->info(json_encode($return));
    }
}
