<?php

namespace App\Services\Kafka\Topics\AuditAuthV1\Consumer;

use App\Services\Kafka\MessageHandlerInterface;
use App\Services\Kafka\Topics\AuditAuthV1\Enums\TopicsEnum;
use App\Services\Kafka\Topics\AuditAuthV1\Process\LoginProcess;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

readonly class AuditLoginHandler implements MessageHandlerInterface
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): bool
    {
        return match ($message->getTopicName()) {
            TopicsEnum::AUDIT_LOGIN_V1->value => LoginProcess::process($message),
            default => throw new \Exception('Unexpected match value: enviar para uma DLQ')
        };
    }
}
