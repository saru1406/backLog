<?php

namespace App\Services;

use App\Models\Company;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CompanyService implements CompanyServiceInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function patchUserByCompanyId(int $userId, int $companyId): void
    {
        $this->userRepository->patchUserByCompanyId($userId, $companyId);
    }

    /**
     * {@inheritDoc}
     */
    public function isCompanyInfoRegistered(): bool
    {
        $domain = $this->fetchDomain();
        $isDomain = $this->companyRepository->isDomainPresent($domain);
        $isGmailDomain = ('gmail.com' === $domain);

        return $isDomain && $isGmailDomain;
    }

    /**
     * {@inheritDoc}
     */
    public function storeCompany(string $companyName): Company
    {
        $domain = $this->fetchDomain();
        return $this->companyRepository->storeCompany($companyName, $domain);
    }

    /**
     * ドメイン取得
     *
     * @return string
     */
    private function fetchDomain(): string
    {
        $user = Auth::user();
        $userEmail = $user->email;
        return explode('@', $userEmail)[1];
    }
}
