<?php

namespace App\Console\Commands;

use App\Services\Kafka\Core\Consumer\ConsumerService;
use App\Services\Kafka\Enums\TopicsEnum;
use App\Services\Kafka\Enums\ConsumerGroupEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Consumers\AuditAuthHandlerConsumer;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Exceptions\ConsumerException;

class KafkaConsumerAuditC1Command extends Command
{
    protected $signature = 'kafka-consumer:audit-auth-v1-c1';

    protected $description = 'Consome mensagens';

    /**
     * @throws Exception
     * @throws ConsumerException
     */
    public function handle(): void
    {
        $this->info("Consumindo mensagens do tópico [audit-login-v1, audit-recovery-v1, audit-to-throw-error] no consumer 1...");
        new ConsumerService(
            topics: [
                TopicsEnum::AUDIT_LOGIN_V1->value,
                TopicsEnum::AUDIT_RECOVERY_V1->value,
                TopicsEnum::AUDIT_LOGIN_V1_THROW_ERROR->value,
                'unknow-topic'
            ],
            consumerGroup: ConsumerGroupEnum::SERVICE_1,
            messageHandler: new AuditAuthHandlerConsumer(),
            deadLetterTopic: TopicsEnum::AUDIT_LOGIN_V1_DLQ
        )->execute();
    }
}
