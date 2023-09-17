<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
        /**
         * プロジェクト保存
         *
         * @param string $name
         * @param string $key
         * @return void
         */
        public function storeProjet(string $name, string $key): void;

        /**
         * プロジェクトの名取得
         *
         * @return Collection
         */
        public function getProjectNames(): Collection;
}
