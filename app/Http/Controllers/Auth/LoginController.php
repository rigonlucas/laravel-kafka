<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Kafka\Core\Producer\ProducerService;
use App\Services\Kafka\Enums\AuthTopicsEnum;
use App\Services\Kafka\Topics\AuditAuth\V1\Messages\AuditAuthMessage;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::query()->where('email', $request->email)->firstOrFail();
        if (!\Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $auditMessage = new AuditAuthMessage(
            eventId: Ulid::generate(),
            userName: $user->name,
            action: 'login',
            timestamp: now(),
            ipAddress: $request->ip(),
            userAgent: $request->userAgent(),
            accountUuid: Uuid::fromString($user->uuid)
        );

        new ProducerService(
            AuthTopicsEnum::AUDIT_LOGIN_V1->value,
            $auditMessage->getMessage()
        )->execute();

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }
}
