<?php

namespace App\Console\Commands;

use App\Services\Kafka\ConsumerService;
use App\Services\Kafka\Topics\AuditLoginV1\Consumer\AuditLoginHandler;
use App\Services\Kafka\Topics\AuditLoginV1\Enums\GroupIdEnum;
use App\Services\Kafka\Topics\AuditLoginV1\Enums\TopicsEnum;
use Illuminate\Console\Command;

class KafkaConsumerAuditC2Command extends Command
{
    protected $signature = 'kafka-consumer:audit-login-v1-c2';

    protected $description = 'Consome mensagens';

    public function handle(): void
    {
        $this->info("Consumindo mensagens do tópico audit-login-v1 no consumer 2...");
        new ConsumerService(
            [TopicsEnum::AUDIT_LOGIN_V1->value],
            GroupIdEnum::SERVICE_2->value,
            new AuditLoginHandler()
        )->execute();
    }
}
