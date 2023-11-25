<?php

namespace App\Repositories;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    /**
     * ドメインの有無を判定
     *
     * @param string $domain
     * @return boolean
     */
    public function isDomainPresent(string $domain): bool;

    /**
     * 企業情報を保存
     *
     * @param string $companyName
     * @param string $domain
     * @return Company
     */
    public function storeCompany(string $companyName, string $domain): Company;

    /**
     * 企業に所属しているユーザか判定
     *
     * @param int $userId
     * @return bool
     */
    public function isCompanyByuserId(int $userId): bool;
}
