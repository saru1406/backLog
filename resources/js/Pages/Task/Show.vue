<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'

defineProps({
    'project': Object,
    'task': Object,
    'task_user': Object,
})

</script>

<template>
    <Head :title="project.name" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template> -->

        <div class="flex w-full">
            <SideMenu :project="project" class="h-screen" />
            <!-- 左側のコンテナ -->
            <div class="p-6 text-gray-900 w-full">
                <div class="p-10">
                    <p class="font-semibold">{{ task.title }}</p>
                    <Link :href="route('projects.tasks.edit', { project: project, task: task })"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    編集</Link>
                    <label class="pl-5">開始日</label>{{ task.start_date }}
                    <label class="pl-5">終了日</label>{{ task.end_date }}
                    <div class="h-auto bg-white p-4">
                        <div>
                            <p class="font-semibold p-5">概要</p>
                            <hr>
                        </div>
                        <div>
                            <p class="font-semibold p-5">詳細</p>
                            <p class="p-5">{{ task.content }}</p>
                            <hr>
                        </div>
                        <div>
                            <p class="font-semibold p-5">備考</p>
                            <hr>
                            <p class="m-3">優先度</p>{{ task.priority }}
                            <hr>
                            <p class="m-3">カテゴリー</p>
                            <hr>
                            <p class="m-3">担当者</p>{{ task_user.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
