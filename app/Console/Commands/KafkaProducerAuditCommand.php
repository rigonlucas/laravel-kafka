<?php

namespace App\Console\Commands;

use App\Services\Kafka\ProducerService;
use App\Services\Kafka\Topics\AuditLoginV1\Enums\TopicsEnum;
use App\Services\Kafka\Topics\AuditLoginV1\Message\AuditLoginMessage;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

class KafkaProducerAuditCommand extends Command
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
            $auditMessage = new AuditLoginMessage(
                eventId: Ulid::generate(),
                userName: fake()->name(),
                action: 'login',
                timestamp: now(),
                ipAddress: fake()->ipv4(),
                userAgent: fake()->userAgent(),
                accountUuid: $accountUuid
            );

            $return = new ProducerService(TopicsEnum::AUDIT_LOGIN_V1->value, $auditMessage->getMessage())->execute();
            $this->info(json_encode($return));
        }
    }
}
