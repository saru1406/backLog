<?php

namespace App\Services;

interface GoogleServiceInterface
{
    /**
     * リダイレクトURI作成
     *
     * @return string
     */
    public function createRedirectUri(): string;

    /**
     * GoogleOauth認証でログイン
     *
     * @return void
     */
    public function loginGoogleOauth(): void;
}
