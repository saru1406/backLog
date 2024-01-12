<?php

declare(strict_types=1);

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
