<?php

namespace App\Modules\User\Infrastructure\Http\Controller;

use App\Core\Controller;
use App\Modules\User\Application\DTO\AuthService\LoginDTO;
use App\Modules\User\Infrastructure\Http\Request\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(): \Inertia\Response
    {
        return $this->rendering('User/Login',[]);
    }

    /**
     * @throws ValidationException
     */
    public function handleLogin(LoginRequest $request): RedirectResponse
    {
        // Kiểm tra giới hạn đăng nhập
        $rateLimitResult = $this->authService->rateLimitLogin();
        if (!$rateLimitResult->isSuccess()) {
            throw ValidationException::withMessages([
                'email' => $rateLimitResult->getMessage(),
            ]);
        }

        $result = $this->authService->login(new LoginDTO(
            email: $request->email,
            password: $request->password,
        ));
        if ($result->isSuccess()) {
            return redirect()->route('dashboard');
        }else{
            throw ValidationException::withMessages([
                'email' => $result->getMessage(),
            ]);
        }
    }

    public function logout(): \Illuminate\Routing\Redirector|RedirectResponse
    {
        $this->authService->logout();
        return redirect()->route('login');

    }
}
