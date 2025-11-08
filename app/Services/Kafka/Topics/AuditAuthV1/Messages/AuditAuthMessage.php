<?php

namespace App\Services\Kafka\Topics\AuditAuthV1\Messages;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Junges\Kafka\Message\Message;
use Ramsey\Uuid\UuidInterface;

readonly class AuditAuthMessage implements Arrayable
{
    public function __construct(
        public string $eventId,
        public string $userName,
        public string $action,
        public Carbon $timestamp,
        public string $ipAddress,
        public string $userAgent,
        public UuidInterface $accountUuid
    ) {
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->eventId,
            'user_name' => $this->userName,
            'action' => $this->action,
            'timestamp' => $this->timestamp->toIso8601String(),
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'account_uuid' => $this->accountUuid->toString(),
        ];
    }

    public function getMessage(): Message
    {
        return new Message(
            headers: [
                'content-type' => 'application/json',
                'account-uuid' => $this->accountUuid->toString(),
            ],
            body: $this->toArray(),
            key: $this->accountUuid->toString()
        );
    }
}
