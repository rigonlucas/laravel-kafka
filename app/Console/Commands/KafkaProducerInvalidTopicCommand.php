<?php

namespace App\Console\Commands;

use App\Services\Kafka\Core\Producer\ProducerService;
use App\Services\Kafka\Topics\AuditAuth\V1\Messages\AuditAuthMessage;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

class KafkaProducerInvalidTopicCommand extends Command
{
    protected $signature = 'kafka-producer:invalid-topic';

    protected $description = 'Produz mensagens de auditoria de login em um tópico inválido';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
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

        $return = new ProducerService('unknow-topic', $auditMessage->getMessage())->execute();
        $this->info(json_encode($return));
    }
}
