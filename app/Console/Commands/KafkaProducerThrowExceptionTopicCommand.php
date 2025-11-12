<?php

namespace App\Console\Commands;

use App\Services\Kafka\Core\Producer\ProducerService;
use App\Services\Kafka\Enums\TopicsEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Messages\AuditAuthMessage;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

class KafkaProducerThrowExceptionTopicCommand extends Command
{
    protected $signature = 'kafka-producer:dlq-topic';

    protected $description = 'Produz mensagens que lançam exceção para enviar a uma DLQ';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $accountUuid = Uuid::uuid7();
        $auditMessage = new AuditAuthMessage(
            eventId: Ulid::generate(),
            userName: fake()->name(),
            action: 'topic-nao-implementado',
            timestamp: now(),
            ipAddress: fake()->ipv4(),
            userAgent: fake()->userAgent(),
            accountUuid: $accountUuid
        );

        $return = new ProducerService(
            topic: TopicsEnum::AUDIT_LOGIN_V1_THROW_ERROR->value,
            message: $auditMessage->getMessage()
        )->execute();
        $this->info(json_encode($return));
    }
}
