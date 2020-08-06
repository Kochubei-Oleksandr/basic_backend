<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class BaseAuthController extends BaseController
{
    protected string $guard;

    public function login(LoginRequest $request)
    {
        return $this->loginAttempt($request->only(['email', 'password']));
    }

    public function registerAttempt(Request $request)
    {
        if (parent::createOne($request)) {
            return $this->loginAttempt($request->only(['email', 'password']));
        }
        return $this->responseWithError('Something went wrong. Try later', 500);

    }

    protected function loginAttempt(array $credentials)
    {
        if (!$token = Auth::guard($this->guard)->attempt($credentials)) {
            return $this->responseWithError('You have incorrectly entered your username or password', 403);
        }

        return $this->successResponse(['token' => $token]);
    }

    public function refreshToken()
    {
        return $this->successResponse(['token' => Auth::guard($this->guard)->refresh()]);
    }

    public function logout()
    {
        Auth::guard($this->guard)->logout();

        return $this->successResponse(['message' => 'You have successfully logged out']);
    }
}
