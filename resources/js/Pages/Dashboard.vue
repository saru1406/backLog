<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 flex w-full">
            <!-- 左側のコンテナ -->
            <div class="flex flex-col w-1/2 sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    <p>プロジェクト一覧</p>
                    <!-- <Link :href="route('')"> -->
                        プロジェクト作成
                    <!-- </Link> -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">
                            プロジェクト一覧中身
                        </div>
                    </div>
                </div>
                <div class="p-6 text-gray-900">自分の課題
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">自分の課題一覧中身</div>
                    </div>
                </div>
            </div>

            <!-- 右側のコンテナ -->
            <div class="flex flex-col w-1/2 sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">最近の更新
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">最近の更新中身</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
