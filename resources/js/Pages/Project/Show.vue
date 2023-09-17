<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'

defineProps({
    'project': Object
})

</script>

<template>
    <Head :title="project.name" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template> -->

        <div class="flex w-full">
            <SideMenu class="h-screen"/>
            <!-- 左側のコンテナ -->
                <div class="flex flex-col w-3/5 sm:px-6 lg:px-8 py-12">
                    <div class="p-6 text-gray-900">
                        <p>プロジェクトのホーム: 最近の更新</p>
                        <div class="bg-white overflow-hidden shadow-sm border border-gray-200">
                            <div class="p-6 text-gray-900 text-center">
                                プロジェクト更新一覧
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 右側のコンテナ -->
                <div class="flex flex-col w-2/5 sm:px-6 lg:px-8 py-12">
                    <div class="p-6 text-gray-900">状態
                        <div class="bg-white overflow-hidden shadow-sm border border-gray-200">
                            <div class="p-6 text-gray-900 text-center">最近の更新中身</div>
                        </div>
                    </div>
                </div>
        </div>
    </AuthenticatedLayout>
</template>
