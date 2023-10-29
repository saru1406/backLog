<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'

const props = defineProps({
    'project': Object,
    'task': Object,
    'child_task_user': Object,
    'child_task': Object,
    'child_tasks': Array
})

const renderChildTaskShow = (childTask) =>
    router.get(`/projects/${props.project.id}/tasks/${props.task.id}/child-tasks/${childTask.id}`)

console.log(props.child_tasks)
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
                    <p class="font-semibold">{{ props.child_task.title }}</p>
                    <Link :href="route('projects.tasks.child-tasks.edit', { project: project, task: task, child_task: child_task })"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    編集</Link>
                    <label class="pl-5">開始日</label>{{ props.child_task.start_date }}
                    <label class="pl-5">終了日</label>{{ props.child_task.end_date }}
                    <div class="h-auto bg-white p-4">
                        <div>
                            <p class="font-semibold p-5">概要</p>
                            <hr>
                        </div>
                        <div>
                            <p class="font-semibold p-5">詳細</p>
                            <p class="p-5">{{ props.child_task.content }}</p>
                            <hr>
                        </div>
                        <div>
                            <p class="font-semibold p-5">備考</p>
                            <hr>
                            <p class="m-3">優先度</p>{{ props.child_task.priority }}
                            <hr>
                            <p class="m-3">カテゴリー</p>
                            <hr>
                            <p class="m-3">担当者</p>{{ props.child_task_user.name }}
                        </div>
                    </div>
                    <!-- TODOモーダルでcreate画面表示する -->
                    <div class="h-auto mt-10 bg-white p-4">
                        <Link :href="route('projects.tasks.child-tasks.create', { project: props.project, task: props.task })">子課題を追加
                        </Link>
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl text-center">
                                        件名</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">
                                        担当者</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">
                                        状態</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">
                                        優先度</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">
                                        開始日</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">
                                        期限日</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">
                                        登録日</th>
                                    <th
                                        class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-for="childTask in props.child_tasks" :key="childTask.id">
                                <tr class="border-b border-gray-300 hover:bg-blue-200"
                                    @click="renderChildTaskShow(childTask)">
                                    <td class="px-4 py-3 w-1/5">{{ childTask.title }}</td>
                                    <td class="px-4 py-3">{{ childTask.user.name }}</td>
                                    <td class="px-4 py-3">{{ childTask.status }}</td>
                                    <td class="px-4 py-3 text-lg">{{ childTask.priority }}</td>
                                    <td class="px-4 py-3">
                                        {{ childTask.start_date }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ childTask.end_date }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ childTask.created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
