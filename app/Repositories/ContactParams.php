<?php

namespace App\Repositories;

class ContactParams
{
    public function __construct(
        private string $category,
        private string $content,
    ) {
        $this->category = $category;
        $this->content = $content;
    }

    /**
     * 配列に変換
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'category' => $this->category,
            'content' => $this->content,
        ];
    }

    /**
     * カテゴリーを取得
     *
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * コンテンツを取得
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
