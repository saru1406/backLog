<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { ref, reactive } from 'vue';

const form = reactive({
    category: '',
    content: '',
});

function confirmContact() {
    router.post('/contacts/confirm', form)
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">お問い合わせフォーム</h2>
        </template>

        <div class="container mx-auto">
            <div v-if="errorMessage" class="error-message">
                {{ errorMessage }}
            </div>
            <div class="w-full">
                <form @submit.prevent="confirmContact">
                    <div class="p-6 text-gray-900">カテゴリー
                        <select v-model="form.category"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-1 mr-5">
                            <option value="" disabled selected>選択してください</option>
                            <optgroup label="アカウント関連">
                                <option value="パスワードのリセット">パスワードのリセット</option>
                                <option value="ユーザー名またはメールアドレスの変更">ユーザー名またはメールアドレスの変更</option>
                                <option value="アカウントの停止または削除">アカウントの停止または削除</option>
                            </optgroup>
                            <optgroup label="製品/サービスのサポート">
                                <option value="製品の使用方法">製品の使用方法</option>
                                <option value="不具合やエラーに関する問い合わせ">不具合やエラーに関する問い合わせ</option>
                                <option value="互換性や仕様に関する質問">互換性や仕様に関する質問</option>
                            </optgroup>
                            <!-- <optgroup label="料金と請求">
                            <option value="請求書や料金に関する問い合わせ">請求書や料金に関する問い合わせ</option>
                            <option value="支払い方法の変更">支払い方法の変更</option>
                            <option value="返金ポリシーに関する質問">返金ポリシーに関する質問</option>
                        </optgroup> -->
                            <optgroup label="技術的なサポート">
                                <option value="システムやソフトウェアのエラー">システムやソフトウェアのエラー</option>
                                <option value="インストールやアップデートに関する問題">インストールやアップデートに関する問題</option>
                                <option value="互換性や技術仕様に関する質問">互換性や技術仕様に関する質問</option>
                            </optgroup>
                            <optgroup label="フィードバックと提案">
                                <option value="製品やサービスのフィードバック">製品やサービスのフィードバック</option>
                                <option value="新機能や改善に関する提案">新機能や改善に関する提案</option>
                                <option value="一般的なコメントや意見">一般的なコメントや意見</option>
                            </optgroup>
                            <optgroup label="プライバシーとセキュリティ">
                                <option value="個人情報の取り扱いに関する問い合わせ">個人情報の取り扱いに関する問い合わせ</option>
                                <option value="セキュリティ懸念や報告">セキュリティ懸念や報告</option>
                                <option value="利用規約やプライバシーポリシーに関する質問">利用規約やプライバシーポリシーに関する質問</option>
                            </optgroup>
                            <optgroup label="その他の問い合わせ">
                                <option value="以上のカテゴリに当てはまらない一般的な問い合わせ">以上のカテゴリに当てはまらない一般的な問い合わせ</option>
                                <option value="メディア関連の問い合わせ">メディア関連の問い合わせ</option>
                                <option value="企業情報やパートナーシップに関する質問">企業情報やパートナーシップに関する質問</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="p-6 text-gray-900">お問い合わせ内容
                        <textarea v-model="form.content"
                            class="w-full h-96 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="text-center">
                    <PrimaryButton>追加</PrimaryButton>
                </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
