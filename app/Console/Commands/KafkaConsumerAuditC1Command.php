<?php

namespace App\Console\Commands;

use App\Services\Kafka\Core\ConsumerService;
use App\Services\Kafka\Enums\AuthTopicsEnum;
use App\Services\Kafka\Enums\GroupIdEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Consumers\AuditAuthHandler;
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
        $this->info("Consumindo mensagens do tópico [audit-login-v1, audit-recovery-v1] no consumer 1...");
        new ConsumerService(
            [
                AuthTopicsEnum::AUDIT_LOGIN_V1->value,
                AuthTopicsEnum::AUDIT_RECOVERY_V1->value,
            ],
            GroupIdEnum::SERVICE_1->value,
            new AuditAuthHandler()
        )->execute();
    }
}
