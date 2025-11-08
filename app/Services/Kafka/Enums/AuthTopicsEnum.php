<?php

namespace App\Services\Kafka\Enums;

enum AuthTopicsEnum: string
{
    case DEAD_LETTER_QUEUE = 'dead-letter-queue';
    case AUDIT_LOGIN_V1 = 'audit-login-v1';
    case AUDIT_RECOVERY_V1 = 'audit-recovery-v1';
}
