<?php

namespace App\Services\Kafka\Topics\AuditAuth\V1\Consumers;

use App\Services\Kafka\Core\ConsumerMessageHandler;
use App\Services\Kafka\Enums\AuthTopicsEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Process\LoginProcess;
use App\Services\Kafka\Topics\AuditAuth\V1\Process\RecoveryProcess;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

readonly class AuditAuthHandlerConsumer implements ConsumerMessageHandler
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): bool
    {
        return match ($message->getTopicName()) {
            AuthTopicsEnum::AUDIT_LOGIN_V1->value => LoginProcess::process($message),
            AuthTopicsEnum::AUDIT_RECOVERY_V1->value => RecoveryProcess::process($message),
            default => throw new \Exception('Unexpected match value: enviar para uma DLQ')
        };
    }
}
