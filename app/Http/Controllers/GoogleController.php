<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GoogleServiceInterface;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function __construct(
        private GoogleServiceInterface $googleService
    ) {
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $this->googleService->loginGoogleOauth();

        return to_route('companies.create');
    }
}
