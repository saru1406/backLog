<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GoogleServiceInterface;
use Google_Client;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function __construct(
        private GoogleServiceInterface $googleService
    ) {
    }

    public function redirectToGoogle()
    {
        $loginUrl = $this->googleService->createRedirectUri();

        return redirect($loginUrl);
    }

    public function handleGoogleCallback()
    {
        $this->googleService->loginGoogleOauth();

        return to_route('companies.create');
    }
}
