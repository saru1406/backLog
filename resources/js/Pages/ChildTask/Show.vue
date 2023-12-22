<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'

const props = defineProps({
    'project': Object,
    'task': Object,
    'childTask': Object,
})

const renderChildTaskShow = (childTask) =>
    router.get(`/projects/${props.project.id}/tasks/${props.task.id}/child-tasks/${childTask.id}`)

function deleteChildTask() {
    router.delete(`/projects/${props.project.id}/tasks/${props.task.id}/child-tasks/${props.childTask.id}`)
}

const formatDate = (dateString) => {
    if (!dateString) return '';

    // Dateインスタンスを作成
    const date = new Date(dateString);

    // 年月日を取得
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');

    // フォーマットされた文字列を返す
    return `${year}/${month}/${day}`;
};

</script>

<template>
    <Head :title="project.name" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template> -->

        <div class="flex w-full">
            <SideMenu :project="project" class="h-screen" />
            <div class="p-6 text-gray-900 w-full">
                <div class="p-10">
                    <div class="h-auto bg-white p-10 rounded border border-gray-200">
                        <div>
                            <div class="flex">
                                <p class="font-semibold pl-5">タイトル</p>
                                <p class="ml-auto">
                                    <!-- 登録者： {{ props.childTask.creator.name }}<br> -->
                                    登録日時： {{ formatDate(props.childTask.created_at) }}
                                </p>
                            </div>
                            <p class="font-semibold px-5 pt-8 pb-5 text-sm">{{ props.childTask.title }}</p>
                            <hr>
                        </div>
                        <div>
                            <p class="font-semibold p-5">詳細</p>
                            <p class="p-5">{{ props.childTask.content }}</p>
                            <hr>
                        </div>
                        <table class="w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="border-b border-gray-300 py-8 pl-8 text-left w-1/6">状態</td>
                                    <td class="border-b border-gray-300 w-80">
                                        <span v-if="props.childTask.status === '完了'" class="rounded-full py-2 px-6 bg-slate-300">
                                            {{ props.childTask.status }}
                                        </span>
                                        <span v-if="props.task.status === '処理済み'"
                                            class="rounded-full py-2 px-6 bg-indigo-200">
                                            {{ props.childTask.status }}
                                        </span>
                                        <span v-if="props.task.status === '未対応'"
                                            class="rounded-full py-2 px-6 bg-orange-200">
                                            {{ props.childTask.status }}
                                        </span>
                                        <span v-if="props.task.status === '処理中'"
                                            class="rounded-full py-2 px-6 bg-green-300">
                                            {{ props.childTask.status }}
                                        </span>
                                    </td>
                                    <td class="w-1/12"></td>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300 w-1/6">担当者</td>
                                    <td class="border-b border-gray-300 w-80">{{ props.childTask.user.name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300 py-8 w-1/6">優先度</td>
                                    <td v-if="props.childTask.priority === '高'" class="text-lg text-red-600 border-b border-gray-300">
                                        {{ props.childTask.priority }}
                                    </td>
                                    <td v-if="props.childTask.priority === '中'"
                                        class="text-lg text-green-500 border-b border-gray-300">
                                        {{ props.childTask.priority }}
                                    </td>
                                    <td v-if="props.childTask.priority === '低'" class="text-lg text-blue-500 border-b border-gray-300">
                                        {{ props.childTask.priority }}
                                    </td>
                                    <td v-if="!props.childTask.priority" class="text-lg text-red-600 border-b border-gray-300"></td>
                                    <td class="w-1/12"></td>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300">種別</td>
                                    <td v-if="props.childTask.type" class="border-b border-gray-300">
                                        <span v-if="props.childTask.type.name === 'バグ'"
                                            class="rounded-full py-2 px-6 bg-red-600 text-white text-xs">
                                            {{ props.childTask.type.name }}
                                        </span>
                                        <span v-if="props.childTask.type.name === '実装'"
                                            class="rounded-full py-2 px-6 bg-blue-600 text-white text-xs">
                                            {{ props.childTask.type.name }}
                                        </span>
                                        <span v-if="props.childTask.type.name === '改善'"
                                            class="rounded-full py-2 px-6 bg-pink-600 text-white text-xs">
                                            {{ props.childTask.type.name }}
                                        </span>
                                        <span
                                            v-if="props.childTask.type.name !== '改善' && props.childTask.type.name !== '実装' && props.childTask.type.name !== 'バグ'"
                                            class="rounded-full py-2 px-6 bg-slate-500 ml-10 text-white text-xs">
                                            {{ props.childTask.type.name }}
                                        </span>
                                    </td>
                                    <td v-if="!props.childTask.type" class="border-b border-gray-300"></td>
                                </tr>
                                <tr>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300 py-8">ブランチ名</td>
                                    <td class="border-b border-gray-300">
                                        <span class="">{{ props.childTask.branch_name }}</span>
                                        <button v-if="!props.childTask.branch_name" @click="storeBranchGpt"
                                            class="text-sm inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            GPTでブランチ名を自動作成
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-8 text-left border-b border-gray-300 py-8">開始日</td>
                                    <td class="border-b border-gray-300 text-base">{{ formatDate(props.childTask.start_date) }}
                                    </td>
                                    <td class="w-1/12"></td>
                                    <td class="pl-8 text-left border-b border-gray-300">終了日</td>
                                    <td class="border-b border-gray-300 text-base">{{ formatDate(props.childTask.end_date) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-end my-5">
                        <Link
                        :href="route('projects.tasks.child-tasks.edit', { project: project, task: task, child_task: childTask })"
                            class="mx-6 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        編集</Link>
                        <div @click="deleteChildTask" style="cursor: pointer;"
                            class="text-right inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            タスク削除
                        </div>
                    </div>
                    <!-- TODOモーダルでcreate画面表示する -->
                    <div class="h-auto mt-10 bg-white p-4 rounded border border-gray-200">
                        <div class="flex">
                            <button @click="showModal = true"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-10 my-5">
                                子課題を追加
                            </button>
                        </div>
                        <div class="bg-gray-100 inline-flex px-4 pb-2 pt-4 rounded-t-lg text-sm font-medium">子課題一覧</div>
                        <table class="table-auto w-full text-left whitespace-no-wrap text-sm shadow-lg">
                            <thead class="text-green-700">
                                <tr>
                                    <th
                                        class="px-5 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 rounded-tl rounded-bl text-center">
                                        件名</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                        担当者</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                        状態</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                        優先度</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                        開始日</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                        期限日</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                        登録日</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-300 hover:bg-blue-200">
                                    <td class="pl-9 py-6 w-1/5">{{ props.task.title }}</td>
                                    <td class="px-4 py-6 text-center">{{ props.task.user.name }}</td>
                                    <td class="px-4 py-6 text-center">{{ props.task.status }}</td>
                                    <td class="px-4 py-6 text-lg text-center">{{ props.task.priority }}</td>
                                    <td class="px-4 py-6 text-center">
                                        {{ formatDate(props.task.start_date) }}
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        {{ formatDate(props.task.end_date) }}
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        {{ formatDate(props.task.created_at) }}
                                    </td>
                                </tr>
                                <tr v-for="childTask in props.task.child_tasks" :key="childTask.id" class="border-b border-gray-300 hover:bg-blue-200" :class="{ 'bg-blue-200': props.childTask.id === childTask.id }"
                                    @click="renderChildTaskShow(childTask)">
                                    <td class="pl-16 py-6 w-1/5">{{ childTask.title }}</td>
                                    <td class="px-2 py-6 text-center">{{ childTask.user.name }}</td>
                                    <td class="px-2 py-6 text-center">{{ childTask.status }}</td>
                                    <td class="px-2 py-6 text-lg text-center">{{ childTask.priority }}</td>
                                    <td class="px-2 py-6 text-center">
                                        {{ formatDate(childTask.start_date) }}
                                    </td>
                                    <td class="px-2 py-6 text-center">
                                        {{ formatDate(childTask.end_date) }}
                                    </td>
                                    <td class="px-2 py-6 text-center">
                                        {{ formatDate(childTask.created_at) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout></template>
