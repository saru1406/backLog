<?php

namespace App\Services;

use App\Repositories\ContactParams;
use App\Repositories\ContactRepositoryInterface;

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
}
