<?php

namespace App\Repositories;

interface ContactRepositoryInterface
{
    /**
     * お問い合わせ保存
     *
     * @param array $params
     * @return void
     */
    public function store(array $params): void;
}
