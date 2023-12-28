<?php

namespace App\Services;

use App\Repositories\ContactRepositoryInterface;

class ContactService implements ContactServiceInterface
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository,
    ) {
    }
}
