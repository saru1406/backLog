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
    'childTasks': Array,
    'errors': Object
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
    branch_name: null,
    start_date: null,
    end_date: null,
})

const commentForm = ref('')

function storeChildTask() {
    router.post(`/projects/${props.project.id}/tasks/${props.task.id}/child-tasks`, form)
    // 保存が成功した後にフォームをリセット
    form.user_id = null;
    form.title = null;
    form.content = null;
    form.status = null;
    form.priority = null;
    form.branch_name = null;
    form.start_date = null;
    form.end_date = null;
}

function storeTaskComment() {
    router.post(`/projects/${props.project.id}/tasks/${props.task.id}/comments`, { comment: commentForm.value })
    // 保存が成功した後にフォームをリセット
    commentForm.value = null;
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

function deleteTask() {
    router.delete(`/projects/${props.project.id}/tasks/${props.task.id}`)
}

</script>

<template>
    <Head :title="project.name" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト名：{{ props.project.name }}</h2>
        </template> -->

        <div class="flex w-full">
            <SideMenu :project="project" class="h-screen" />
            <!-- 左側のコンテナ -->
            <div class="p-6 text-gray-900 w-full ml-72">
                <div class="p-5">
                    <div class="h-auto bg-white p-10 rounded border border-gray-200">
                        <div>
                            <div class="flex">
                                <p class="font-semibold pl-5">タイトル</p>
                                <p class="ml-auto">
                                    登録者： {{ props.task.creator.name }}<br>
                                    登録日時： {{ formatDate(props.task.created_at) }}
                                </p>
                            </div>
                            <p class="font-semibold px-5 pt-8 pb-5 text-sm">{{ props.task.title }}</p>
                            <hr>
                        </div>
                        <div>
                            <p class="font-semibold p-5">詳細</p>
                            <div v-html="props.task.content" class="px-5 pt-8 pb-5 text-sm"></div>
                            <hr>
                        </div>
                        <table class="w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="border-b border-gray-300 py-8 pl-8 text-left w-1/6">状態</td>
                                    <td class="border-b border-gray-300 w-80">
                                        <span v-if="props.task.status === '完了'" class="rounded-full py-2 px-6 bg-slate-300">
                                            {{ props.task.status }}
                                        </span>
                                        <span v-if="props.task.status === '処理済み'"
                                            class="rounded-full py-2 px-6 bg-indigo-200">
                                            {{ props.task.status }}
                                        </span>
                                        <span v-if="props.task.status === '未対応'"
                                            class="rounded-full py-2 px-6 bg-orange-200">
                                            {{ props.task.status }}
                                        </span>
                                        <span v-if="props.task.status === '処理中'"
                                            class="rounded-full py-2 px-6 bg-green-300">
                                            {{ props.task.status }}
                                        </span>
                                    </td>
                                    <td class="w-1/12"></td>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300 w-1/6">担当者</td>
                                    <td class="border-b border-gray-300 w-80">{{ props.task.user.name }}</td>
                                </tr>
                                <tr>
                                    <td class="pl-8 text-left border-b border-gray-300 py-8 w-1/6">優先度</td>
                                    <td v-if="task.priority === '高'" class="text-lg text-red-600 border-b border-gray-300">
                                        {{ task.priority }}
                                    </td>
                                    <td v-if="task.priority === '中'"
                                        class="text-lg text-green-500 border-b border-gray-300">
                                        {{ task.priority }}
                                    </td>
                                    <td v-if="task.priority === '低'" class="text-lg text-blue-500 border-b border-gray-300">
                                        {{ task.priority }}
                                    </td>
                                    <td v-if="!task.priority" class="text-lg text-red-600 border-b border-gray-300"></td>
                                    <td class="w-1/12"></td>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300">種別</td>
                                    <td v-if="props.task.type" class="border-b border-gray-300">
                                        <span v-if="props.task.type.name === 'バグ'"
                                            class="rounded-full py-2 px-6 bg-red-600 text-white text-xs">
                                            {{ props.task.type.name }}
                                        </span>
                                        <span v-if="props.task.type.name === '実装'"
                                            class="rounded-full py-2 px-6 bg-blue-600 text-white text-xs">
                                            {{ props.task.type.name }}
                                        </span>
                                        <span v-if="props.task.type.name === '改善'"
                                            class="rounded-full py-2 px-6 bg-pink-600 text-white text-xs">
                                            {{ props.task.type.name }}
                                        </span>
                                        <span
                                            v-if="props.task.type.name !== '改善' && props.task.type.name !== '実装' && props.task.type.name !== 'バグ'"
                                            class="rounded-full py-2 px-6 bg-slate-500 ml-10 text-white text-xs">
                                            {{ props.task.type.name }}
                                        </span>
                                    </td>
                                    <td v-if="!props.task.type" class="border-b border-gray-300"></td>
                                </tr>
                                <tr>
                                    <td class="pl-8 text-left border-b border-gray-300 py-8">ブランチ名</td>
                                    <td class="border-b border-gray-300">
                                        <span class="">{{ props.task.branch_name }}</span>
                                        <button v-if="!props.task.branch_name" @click="storeBranchGpt"
                                            class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            GPTでブランチ名を自動作成
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-8 text-left border-b border-gray-300 py-8">開始日</td>
                                    <td class="border-b border-gray-300 text-base">{{ formatDate(props.task.start_date) }}
                                    </td>
                                    <td class="w-1/12"></td>
                                    <td class="pl-8 text-left border-b border-gray-300">終了日</td>
                                    <td class="border-b border-gray-300 text-base">{{ formatDate(props.task.end_date) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="flex justify-end my-5">
                        <Link :href="route('projects.tasks.edit', { project: project, task: task })"
                            class="mx-6 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        編集
                        </Link>
                        <div @click="deleteTask" style="cursor: pointer;"
                            class="text-right inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            タスク削除
                        </div>
                    </div>
                    <div class="h-auto mt-10 bg-white p-4 rounded border border-gray-200">
                        <div class="flex">
                            <button @click="showModal = true"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-10 my-5">
                                子課題を追加
                            </button>
                            <button v-if="!props.childTasks || props.childTasks.length === 0" @click="storeChildTaskGpt"
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
                            <tbody v-for="childTask in props.childTasks" :key="childTask.id">
                                <tr class="border-b border-gray-300 hover:bg-blue-200"
                                    @click="renderChildTaskShow(childTask)">
                                    <td class="px-4 py-3 w-1/5">{{ childTask.title }}</td>
                                    <td class="px-4 py-3 text-center">{{ childTask.user.name }}</td>
                                    <td class="px-2 py-6 text-center text-xs">
                                        <span v-if="childTask.status === '完了'" class="rounded-full py-2 px-6 bg-slate-300">
                                            {{ childTask.status }}
                                        </span>
                                        <span v-if="childTask.status === '処理済み'"
                                            class="rounded-full py-2 px-6 bg-indigo-200">
                                            {{ childTask.status }}
                                        </span>
                                        <span v-if="childTask.status === '未対応'"
                                            class="rounded-full py-2 px-6 bg-orange-200">
                                            {{ childTask.status }}
                                        </span>
                                        <span v-if="childTask.status === '処理中'" class="rounded-full py-2 px-6 bg-green-300">
                                            {{ childTask.status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-6 text-lg text-center">
                                        <div v-if="childTask.priority === '高'" class=" text-red-600">
                                            {{ childTask.priority }}
                                        </div>
                                        <div v-if="childTask.priority === '中'" class=" text-green-500">
                                            {{ childTask.priority }}
                                        </div>
                                        <div v-if="childTask.priority === '低'" class=" text-blue-500">
                                            {{ childTask.priority }}
                                        </div>
                                    </td>
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

                    <div class="w-full bg-white my-10 border rounded">
                        <h2 class="m-5">コメント</h2>
                        <form @submit.prevent="storeTaskComment" class="flex w-full items-center">
                            <!-- アイテムを中央揃えにする -->
                            <textarea
                                v-model="commentForm"
                                class="w-10/12 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5"
                                rows="2" />
                            <PrimaryButton>コメント追加</PrimaryButton>
                        </form>
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
                    <TextInput type="text" v-model="form.title" class="w-full" placeholder="件名"></TextInput>
                    <div v-if="errors.title" class="text-red-500">
                        {{ errors.title }}
                    </div>
                    <div class="card mt-5">
                        <Editor v-model="form.content" editorStyle="height: 320px" />
                    </div>
                    <table class="w-full text-sm">
                        <tbody>
                            <tr>
                                <td class="border-b border-gray-300 py-16 pl-8 text-left">
                                    状態
                                    <span class="text-red-500 text-lg">*</span>
                                </td>
                                <td class="border-b border-gray-300">
                                    <select v-model="form.status"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                        <option value="未対応">未対応</option>
                                        <option value="処理中">処理中</option>
                                        <option value="処理済み">処理済み</option>
                                        <option value="完了">完了</option>
                                    </select>
                                    <div v-if="errors.status" class="text-red-500 ml-5">
                                        {{ errors.status }}
                                    </div>
                                </td>
                                <td class="w-1/12"></td>
                                <td class="py-3 pl-8 text-left border-b border-gray-300">担当者<span
                                        class="text-red-500 text-lg">*</span></td>
                                <td class="border-b border-gray-300">
                                    <select v-model="form.user_id"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                        <option v-for="projectUser in props.project.users" :key="projectUser.id"
                                            :value="projectUser.id">
                                            {{ projectUser.name }}
                                        </option>
                                    </select>
                                    <div v-if="errors.user_id" class="text-red-500 ml-5">
                                        {{ errors.user_id }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-8 text-left border-b border-gray-300 py-16">優先度</td>
                                <td class="border-b border-gray-300">
                                    <select v-model="form.priority"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                        <option value="低">低</option>
                                        <option value="中">中</option>
                                        <option value="高">高</option>
                                    </select>
                                </td>
                                <td class="w-1/12"></td>
                                <td class="pl-8 text-left border-b border-gray-300 py-16">ブランチ名</td>
                                <td class="border-b border-gray-300">
                                    <TextInput type="text" v-model="form.branch_name" class="m-5 w-4/5"
                                        placeholder="ブランチ名" />
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-8 text-left border-b border-gray-300 py-16">開始日</td>
                                <td class="border-b border-gray-300">
                                    <VueDatePicker style="width: 80%;" v-model="form.start_date"
                                        :disabled-week-days="[6, 0]" locale="jp" format="yyyy/MM/dd" model-type="yyyy-MM-dd"
                                        :enable-time-picker="false" class="m-5" />
                                </td>
                                <td class="w-1/12"></td>
                                <td class="py-6 pl-8 text-left border-b border-gray-300">終了日</td>
                                <td class="border-b border-gray-300">
                                    <VueDatePicker style="width: 80%;" v-model="form.end_date" :disabled-week-days="[6, 0]"
                                        locale="jp" format="yyyy/MM/dd" model-type="yyyy-MM-dd" :enable-time-picker="false"
                                        class="m-5" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-10">
                        <PrimaryButton>追加</PrimaryButton>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
