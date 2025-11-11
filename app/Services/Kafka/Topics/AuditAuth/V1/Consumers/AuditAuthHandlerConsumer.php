<?php

namespace App\Services\Kafka\Topics\AuditAuth\V1\Consumers;

use App\Services\Kafka\Core\Consumer\ConsumerMessageHandler;
use App\Services\Kafka\Core\DefaultDeadLetter\DeadLetterProducerService;
use App\Services\Kafka\Enums\AuthTopicsEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Consumers\Process\LoginProcess;
use App\Services\Kafka\Topics\AuditAuth\V1\Consumers\Process\RecoveryProcess;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

readonly class AuditAuthHandlerConsumer implements ConsumerMessageHandler
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): bool
    {
        return match ($message->getTopicName()) {
            AuthTopicsEnum::AUDIT_LOGIN_V1->value => LoginProcess::process(message: $message),
            AuthTopicsEnum::AUDIT_RECOVERY_V1->value => RecoveryProcess::process(message: $message),
            default => DeadLetterProducerService::sendToDLQ(
                topic: $message->getTopicName(),
                payload: $message->getBody(),
                key: $message->getKey(),
                headers: $message->getHeaders()
            )
        };
    }
}
