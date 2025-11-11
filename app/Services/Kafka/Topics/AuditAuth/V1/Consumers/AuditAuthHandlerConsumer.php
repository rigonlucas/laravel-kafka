<?php

namespace App\Services\Kafka\Topics\AuditAuth\V1\Consumers;

use App\Services\Kafka\Core\Consumer\ConsumerMessageHandler;
use App\Services\Kafka\Core\DefaultDeadLetter\DeadLetterProducerService;
use App\Services\Kafka\Enums\TopicsEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Consumers\Process\LoginProcess;
use App\Services\Kafka\Topics\AuditAuth\V1\Consumers\Process\RecoveryProcess;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

readonly class AuditAuthHandlerConsumer implements ConsumerMessageHandler
{
    /**
     * @throws \Exception
     */
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): bool
    {
        return match ($message->getTopicName()) {
            TopicsEnum::AUDIT_LOGIN_V1->value => LoginProcess::process(message: $message),
            TopicsEnum::AUDIT_RECOVERY_V1->value => RecoveryProcess::process(message: $message),
            default => DeadLetterProducerService::sendToDLQ(
                topic: $message->getTopicName(),
                payload: $message->getBody(),
                key: $message->getKey(),
                authTopicsEnum: TopicsEnum::AUTH_DEAD_LETTER_QUEUE,
                headers: $message->getHeaders()
            )
        };
    }
}
