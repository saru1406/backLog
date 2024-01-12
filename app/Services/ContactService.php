<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ContactParams;
use App\Repositories\ContactRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ContactService implements ContactServiceInterface
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function confirm(ContactParams $params): void
    {
        session()->put([
            'category' => $params->getCategory(),
            'content' => $params->getContent(),
        ]);
    }

    public function store(ContactParams $params): void
    {
        session()->forget(['category', 'content']);

        $paramsArray = $params->toArray();
        $paramsArray['user_id'] = Auth::id();
        $this->contactRepository->store($paramsArray);
    }
}
