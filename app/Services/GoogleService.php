<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleService implements GoogleServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function loginGoogleOauth(): void
    {
        $socialiteUser = Socialite::driver('google')->user();

        // ここでユーザー情報の処理を行います
        $user = $this->userRepository->firstByEmail($socialiteUser->email);
        if (! $user) {
            // ユーザーが存在しない場合は新しく作成
            $params = [
                'name' => $socialiteUser->name,
                'email' => $socialiteUser->email,
                'email_verified_at' => now(),
            ];
            $user = $this->userRepository->store($params);
        }
        Auth::login($user);
    }
}
