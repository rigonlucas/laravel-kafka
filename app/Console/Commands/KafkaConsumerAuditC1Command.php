<?php

namespace App\Console\Commands;

use App\Services\Kafka\ConsumerService;
use App\Services\Kafka\Topics\AuditAuthV1\Consumer\AuditLoginHandler;
use App\Services\Kafka\Topics\AuditAuthV1\Enums\GroupIdEnum;
use App\Services\Kafka\Topics\AuditAuthV1\Enums\TopicsEnum;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Exceptions\ConsumerException;

class KafkaConsumerAuditC1Command extends Command
{
    protected $signature = 'kafka-consumer:audit-login-v1-c1';

    protected $description = 'Consome mensagens';

    /**
     * @throws Exception
     * @throws ConsumerException
     */
    public function handle(): void
    {
        $this->info("Consumindo mensagens do tópico audit-login-v1 no consumer 1...");
        new ConsumerService(
            [TopicsEnum::AUDIT_LOGIN_V1->value],
            GroupIdEnum::SERVICE_1->value,
            new AuditLoginHandler()
        )->execute();
    }
}
