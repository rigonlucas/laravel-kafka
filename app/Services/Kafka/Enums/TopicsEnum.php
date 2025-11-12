<?php

namespace App\Services\Kafka\Enums;

enum TopicsEnum: string
{
    case AUDIT_LOGIN_V1_DLQ = 'auth-login-v1-dlq';
    case AUDIT_LOGIN_V1 = 'auth-login-v1';
    case AUDIT_LOGIN_V1_THROW_ERROR = 'auth-login-v1-to-throw-error';
    case AUDIT_RECOVERY_V1 = 'auth-recovery-v1';
}
