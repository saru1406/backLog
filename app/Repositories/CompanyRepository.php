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

    /**
     * {@inheritDoc}
     */
    public function isCompanyByuserId(int $userId): bool
    {
        return Company::where('user_id', $userId)->exists();
    }
}
