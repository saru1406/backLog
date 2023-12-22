<?php

namespace App\Services;

use App\Repositories\GoogleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Google_Client;
use Google_Service_Oauth2;
use Illuminate\Support\Facades\Auth;

class GoogleService implements GoogleServiceInterface
{
    public function __construct(
        private GoogleRepositoryInterface $googleRepository,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function createRedirectUri(): string
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope("email");
        $client->addScope("profile");

        return $client->createAuthUrl();
    }

    /**
     * {@inheritDoc}
     */
    public function loginGoogleOauth(): void
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $token = $client->fetchAccessTokenWithAuthCode(request()->get('code'));
        $client->setAccessToken($token);

        $googleOauth = new Google_Service_Oauth2($client);
        $googleUserInfo = $googleOauth->userinfo->get();

        // ここでユーザー情報の処理を行います
        $user = $this->userRepository->firstByEmail($googleUserInfo->email);
        if (!$user) {
            // ユーザーが存在しない場合は新しく作成
            $params = [
                'name' => $googleUserInfo->name,
                'email' => $googleUserInfo->email,
                'email_verified_at' => now(),
            ];
            $user = $this->userRepository->store($params);
        }
        Auth::login($user);
    }
}
