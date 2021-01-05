<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\RevokeFailException;
use App\Exceptions\InvalidCredentialException;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{

    /**
     * Validate credentials
     *
     * @param array $credentials
     * @return boolean
     */
    public function validateCredentials($credentials)
    {
        if (! Auth::attempt($credentials)) {
            throw new InvalidCredentialException('login unauthorized', 401);
        }

        return true;
    }

    /**
     * Create token
     *
     * @param User $user
     * @return string
     */
    public function createToken(User $user)
    {
        return $user->createToken('authToken')->plainTextToken;
    }

    /**
     * Get user by token
     *
     * @param string $accessToken
     * @return User
     */
    public function userFromAccessToken($accessToken)
    {
        if(! $token = PersonalAccessToken::findToken($accessToken)) {
            throw new ModelNotFoundException("user not found from token {$accessToken}", 400);
        }

        return $token->tokenable;
    }

    /**
     * Revoke all tokens
     *
     * @param User $user
     * @return void
     */
    public function revokeAllTokens(User $user)
    {
        if (! $user->tokens()->delete()) {
            throw new RevokeFailException('fail revoke all tokens', 400);
        }

        return true;
    }

    /**
     * Revoke token by user id
     *
     * @param User $user
     * @return void
     */
    public function revokeToken(User $user)
    {
        if (! $user->tokens()->where('tokenable_id', $user->id)->delete()) {
            throw new RevokeFailException('fail revoke token', 400);
        }

        return true;
    }
}
