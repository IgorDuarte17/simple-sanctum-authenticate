<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use App\Exceptions\InvalidCredentialException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Mudança de Status
     *
     * @param AuthRequest $request
     * @return json
     */
    public function login(AuthRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);

            $this->authService->validateCredentials($credentials);

            $tokenResult = $this->authService->createToken($request->user());

            return response()->success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'token_expired' => config('sanctum.expiration') * 60
            ]);

        } catch (InvalidCredentialException $exception) {

            return response()->error($exception, $exception->getMessage(), $exception->getCode());
        }
    }

    public function logout($accessToken)
    {
        try {

            $user = $this->authService->userFromAccessToken($accessToken);

            $this->authService->revokeAllTokens($user);

            return response()->success([
                'revoked_token' => $accessToken
            ]);

        } catch (ModelNotFoundException $exception) {

            return response()->error($exception, $exception->getMessage(), $exception->getCode());
        }
    }

    public function getUserByToken($accessToken)
    {
        return $this->authService->userFromAccessToken($accessToken);
    }
}
