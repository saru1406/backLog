<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface CompanyServiceInterface
{
    /**
     * 企業情報を登録するべきか判定
     *
     * @return bool
     */
    public function isCompanyInfoRegistered(): bool;

    /**
     * 企業情報を保存
     *
     * @param string $companyName
     * @return Company
     */
    public function storeCompany(string $companyName): Company;
}
