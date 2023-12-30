<?php

namespace App\Services;

interface GoogleServiceInterface
{
    /**
     * GoogleOauth認証でログイン
     *
     * @return void
     */
    public function loginGoogleOauth(): void;
}
