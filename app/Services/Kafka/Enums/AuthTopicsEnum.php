<?php

namespace App\Services\Kafka\Enums;

enum AuthTopicsEnum: string
{
    case AUTH_DEAD_LETTER_QUEUE = 'auth-dead-letter-queue';
    case AUDIT_LOGIN_V1 = 'auth-login-v1';
    case AUDIT_RECOVERY_V1 = 'auth-recovery-v1';
}
