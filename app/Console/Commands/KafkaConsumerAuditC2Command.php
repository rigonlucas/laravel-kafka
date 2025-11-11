<?php

namespace App\Console\Commands;

use App\Services\Kafka\Core\Consumer\ConsumerService;
use App\Services\Kafka\Enums\AuthTopicsEnum;
use App\Services\Kafka\Enums\ConsumerGroupEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Consumers\AuditAuthHandlerConsumer;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Exceptions\ConsumerException;

class KafkaConsumerAuditC2Command extends Command
{
    protected $signature = 'kafka-consumer:audit-auth-v1-c2';

    protected $description = 'Consome mensagens';

    /**
     * @throws Exception
     * @throws ConsumerException
     */
    public function handle(): void
    {
        $this->info("Consumindo mensagens do tópico audit-login-v1 no consumer 2...");
        new ConsumerService(
            topics: [AuthTopicsEnum::AUDIT_LOGIN_V1->value],
            consumerGroupId: ConsumerGroupEnum::SERVICE_2->value,
            messageHandler: new AuditAuthHandlerConsumer()
        )->execute();
    }
}
