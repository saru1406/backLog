<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ContactParams;

interface ContactServiceInterface
{
    /**
     * Undocumented function
     *
     * @param ContactParams $params
     * @return void
     */
    public function confirm(ContactParams $params);

    /**
     * Undocumented function
     *
     * @param ContactParams $params
     * @return void
     */
    public function store(ContactParams $params): void;
}
