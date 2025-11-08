<?php

namespace App\Console\Commands;

use App\Services\Kafka\Core\ConsumerService;
use App\Services\Kafka\Enums\AuthTopicsEnum;
use App\Services\Kafka\Enums\GroupIdEnum;
use App\Services\Kafka\Topics\AuditAuthV1\Consumers\AuditAuthHandler;
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
            [AuthTopicsEnum::AUDIT_LOGIN_V1->value],
            GroupIdEnum::SERVICE_2->value,
            new AuditAuthHandler()
        )->execute();
    }
}
