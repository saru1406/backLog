<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import Modal from '@/Components/Modal.vue';
import { ref, reactive } from 'vue';
import TextInput from '@/Components/TextInput.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Editor from 'primevue/editor';

const props = defineProps({
    'project': Object,
    'task': Object,
    'task_user': Object,
    'child_tasks': Array,
    'project_users': Object,
    'task_type': Object,
})

const showModal = ref(false);

const renderChildTaskShow = (childTask) =>
    router.get(`/projects/${props.project.id}/tasks/${props.task.id}/child-tasks/${childTask.id}`)

function storeChildTaskGpt() {
    try {
        // isLoading.value = true; // ローディング開始
        router.post(`/projects/${props.project.id}/tasks/${props.task.id}/child-tasks/store-gpt`);
        // 成功時の処理
    } catch (error) {
        // エラー処理
        console.error('エラーが発生しました:', error);
    } finally {
        // isLoading.value = false; // ローディング終了
    }
}

function storeBranchGpt() {
    try {
        // isLoading.value = true; // ローディング開始
        router.post(`/projects/${props.project.id}/tasks/${props.task.id}/create-branch-gpt`);
        // 成功時の処理
    } catch (error) {
        // エラー処理
        console.error('エラーが発生しました:', error);
    } finally {
        // isLoading.value = false; // ローディング終了
    }
}

const form = reactive({
    user_id: null,
    title: null,
    content: null,
    status: null,
    priority: null,
    start_date: null,
    end_date: null,
})

function storeChildTask() {
    router.post(`/projects/${props.project.id}/tasks/${props.task.id}/child-tasks`, form)
    // 保存が成功した後にフォームをリセット
    form.user_id = null;
    form.title = null;
    form.content = null;
    form.status = null;
    form.priority = null;
    form.start_date = null;
    form.end_date = null;
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
            <!-- 左側のコンテナ -->
            <div class="p-6 text-gray-900 w-full">
                <div class="p-10">
                    <Link :href="route('projects.tasks.edit', { project: project, task: task })"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    編集</Link>
                    <label class="pl-5">開始日</label>{{ props.task.start_date }}
                    <label class="pl-5">終了日</label>{{ props.task.end_date }}
                    <div class="h-auto bg-white p-4 rounded">
                        <div>
                            <p class="font-semibold p-5">タイトル</p>
                            <p class="font-semibold p-5">{{ props.task.title }}</p>
                            <hr>
                        </div>
                        <div>
                            <p class="font-semibold p-5">詳細</p>
                            <p class="p-5">{{ props.task.content }}</p>
                            <hr>
                        </div>
                        <div>
                            <div class="my-5">
                                <label class="font-semibold m-3">優先度</label>
                                <span v-if="task.priority === '高'" class="text-red-600 pl-10">
                                    {{ task.priority }}
                                </span>
                                <span v-if="task.priority === '中'" class="text-green-500 pl-10">
                                    {{ task.priority }}
                                </span>
                                <span v-if="task.priority === '低'" class="text-blue-500 pl-10">
                                    {{ task.priority }}
                                </span>
                            </div>
                            <hr>
                            <div class="my-5">
                                <label class="m-3 font-semibold">種別</label>
                                <span v-if="props.task_type">
                                    <span v-if="props.task_type.name === 'バグ'"
                                        class="rounded-full py-2 px-6 bg-red-600 ml-10 text-white">
                                        {{ props.task_type.name }}
                                    </span>
                                    <span v-if="props.task_type.name === '実装'"
                                        class="rounded-full py-2 px-6 bg-blue-600 ml-10 text-white">
                                        {{ props.task_type.name }}
                                    </span>
                                    <span v-if="props.task_type.name === '改善'"
                                        class="rounded-full py-2 px-6 bg-pink-600 ml-10 text-white">
                                        {{ props.task_type.name }}
                                    </span>
                                    <span
                                        v-if="props.task_type.name !== '改善' && props.task_type.name !== '実装' && props.task_type.name !== 'バグ'"
                                        class="rounded-full py-2 px-6 bg-slate-500 ml-10 text-white">
                                        {{ props.task_type.name }}
                                    </span>
                                </span>
                            </div>
                            <hr>
                            <div class="my-5">
                                <label class="m-3 font-semibold">状態</label>
                                <span v-if="props.task.status === '完了'" class="rounded-full py-2 px-6 bg-slate-300 ml-10">
                                    {{ props.task.status }}
                                </span>
                                <span v-if="props.task.status === '処理済み'"
                                    class="rounded-full py-2 px-6 bg-indigo-200 ml-10">
                                    {{ props.task.status }}
                                </span>
                                <span v-if="props.task.status === '未対応'" class="rounded-full py-2 px-6 bg-orange-200 ml-10">
                                    {{ props.task.status }}
                                </span>
                                <span v-if="props.task.status === '処理中'" class="rounded-full py-2 px-6 bg-green-300 ml-10">
                                    {{ props.task.status }}
                                </span>
                            </div>
                            <hr>
                            <div class="my-5">
                                <label class="m-3 font-semibold">担当者</label>
                                <span class="pl-10">{{ props.task_user.name }}</span>
                            </div>
                            <hr>
                            <div class="my-5">
                                <label class="m-3 font-semibold">ブランチ名</label>
                                <span class="pl-10">{{ props.task.branch_name }}</span>
                                <button v-if="!task.branch_name" @click="storeBranchGpt"
                                    class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    GPTでブランチ名を自動作成
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="h-auto mt-10 bg-white p-4 rounded">
                        <div class="flex">
                            <button @click="showModal = true"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-10 my-5">
                                子課題を追加
                            </button>
                            <button v-if="!child_tasks || child_tasks.length === 0" @click="storeChildTaskGpt"
                                class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 my-5">
                                GPTで子課題を自動作成
                            </button>
                        </div>
                        <div class="bg-gray-100 inline-flex px-4 pb-2 pt-4 rounded-t-lg text-sm font-medium">子課題一覧</div>
                        <table class="table-auto w-full text-left whitespace-no-wrap text-sm shadow-lg">
                            <thead class="text-green-700">
                                <tr>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 rounded-tl rounded-bl text-center">
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
                            <tbody v-for="childTask in props.child_tasks" :key="childTask.id">
                                <tr class="border-b border-gray-300 hover:bg-blue-200"
                                    @click="renderChildTaskShow(childTask)">
                                    <td class="px-4 py-3 w-1/5">{{ childTask.title }}</td>
                                    <td class="px-4 py-3 text-center">{{ childTask.user.name }}</td>
                                    <td class="px-4 py-3 text-center">{{ childTask.status }}</td>
                                    <td class="px-4 py-3 text-lg text-center">{{ childTask.priority }}</td>
                                    <td class="px-4 py-3 text-center">
                                        {{ formatDate(childTask.start_date) }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ formatDate(childTask.end_date) }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ formatDate(childTask.created_at) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal :show="showModal" @close="showModal = false" :maxWidth="'3xl'">
        <div class="p-6 text-gray-900 w-full">
            <form @submit.prevent="storeChildTask">
                <div class="bg-white p-5 m-5">
                    <p>子課題の追加</p>
                    <TextInput type="text" v-model="form.title" class="w-full mb-5" placeholder="件名"></TextInput>
                    <div class="card">
                        <Editor v-model="form.content" editorStyle="height: 320px" />
                    </div>
                    <div>
                        <label>状態</label>
                        <select v-model="form.status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="未対応">未対応</option>
                            <option value="処理中">処理中</option>
                            <option value="処理済み">処理済み</option>
                            <option value="完了">完了</option>
                        </select>
                        <label>担当者</label>
                        <select v-model="form.user_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option v-for="projectUser in props.project_users" :key="projectUser.id"
                                :value="projectUser.id">
                                {{ projectUser.name }}
                            </option>
                        </select>
                        <label>優先度</label>
                        <select v-model="form.priority"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="低">低</option>
                            <option value="中">中</option>
                            <option value="高">高</option>
                        </select>
                    </div>
                    <div class="w-1/2 m-5">
                        <label>開始日</label>
                        <VueDatePicker v-model="form.start_date" :disabled-week-days="[6, 0]" locale="jp"
                            format="yyyy/MM/dd" model-type="yyyy-MM-dd" :enable-time-picker="false" />
                    </div>
                    <div class="w-1/2 m-5">
                        <label>終了日</label>
                        <VueDatePicker v-model="form.end_date" :disabled-week-days="[6, 0]" locale="jp" format="yyyy/MM/dd"
                            model-type="yyyy-MM-dd" :enable-time-picker="false" />
                    </div>
                </div>
                <div class="text-center">
                    <PrimaryButton>追加</PrimaryButton>
                </div>
            </form>
    </div>
</Modal></template>
