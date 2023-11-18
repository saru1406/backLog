<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function isDomainPresent(string $domain): bool
    {
        return Company::where('domain', $domain)->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function storeCompany(string $companyName, string $domain): Company
    {
        return Company::create([
            'company_name' => $companyName,
            'domain' => $domain
        ]);
    }
}
