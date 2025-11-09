<?php

namespace App\Console\Commands;

use App\Services\Kafka\Topics\AuditAuth\V1\Messages\AuditAuthMessage;
use App\Services\Kafka\Topics\AuditAuth\V1\Producers\LoginProducer;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

class KafkaProducerAuditLoginCommand extends Command
{
    protected $signature = 'kafka-producer:audit-login-v1';

    protected $description = 'Produz mensagens de auditoria de login';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        for ($i = 1; $i <= 2; $i++) {
            $accountUuid = Uuid::uuid7();
            $auditMessage = new AuditAuthMessage(
                eventId: Ulid::generate(),
                userName: fake()->name(),
                action: 'login',
                timestamp: now(),
                ipAddress: fake()->ipv4(),
                userAgent: fake()->userAgent(),
                accountUuid: $accountUuid
            );

            $return = new LoginProducer()->execute($auditMessage);
            $this->info(json_encode($return));
        }
    }
}
