<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository implements ContactRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function store(array $params): void
    {
        Contact::create($params);
    }
}
