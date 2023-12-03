<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import { reactive, ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import Paginator from 'primevue/paginator';

const props = defineProps({
    'project': Object,
    'project_users': Array
})

const tasks = ref([]);

const pagination = reactive({
    current_page: null,
    links: null,
    last_page: null,
    total: null,
})
console.log(pagination)

const filters = reactive({
    user_id: null,
    status: null,
    priority: null,
    page: null
});

const fetchTasks = async (project, filters) => {
    try {
        let url = `/api/projects/${project.id}/tasks`;
        const params = new URLSearchParams();

        if (filters.user_id !== null) params.append('user_id', filters.user_id);
        if (filters.status !== null) params.append('status', filters.status);
        if (filters.priority !== null) params.append('priority', filters.priority);
        if (filters.page !== null) params.append('page', filters.page);

        const response = await axios.get(url, { params: params });
        tasks.value = response.data.data;
        console.log(response.data.data)
        pagination.current_page = response.data.current_page;
        pagination.links = response.data.links;
        pagination.last_page = response.data.last_page;
        pagination.total = response.data.total;
    } catch (error) {
        console.error('An error occurred while fetching data: ', error);
    }
};

const rowsPerPageOption = computed(() => {
    if (pagination.total > 400) {
        return [10, 20];
    } else if (pagination.total > 200) {
        return [10];
    } else {
        return [1]; // または適切なデフォルト値
    }
});

onMounted(() => {
    // ページ読み込み時にlocalStorageからデータを取得して適用
    const savedUserId = localStorage.getItem("index_user_id");
    const savedStatus = localStorage.getItem("index_status");
    const savedPriority = localStorage.getItem("index_priority");

    // localStorageで保持したデータはstringになる為、"null"をnullに変換
    if (savedUserId === "null") { // 文字列"null"をチェック
        filters.user_id = null; // 実際のnullをセット
    } else {
        filters.user_id = savedUserId; // それ以外はそのままセット
    }

    if (savedStatus === "null") {
        filters.status = null;
    } else {
        filters.status = savedStatus;
    }

    if (savedPriority === "null") {
        filters.priority = null;
    } else {
        filters.priority = savedPriority;
    }

    if (savedUserId === "null" && savedStatus === "null" && savedPriority === "null") {
        fetchTasks(props.project, filters); // 初期データ読み込み
    }
});

watch(filters, () => {
    //フィルターが変更されたときにlocalStorageに保存
    localStorage.setItem("index_user_id", filters.user_id);
    localStorage.setItem("index_status", filters.status);
    localStorage.setItem("index_priority", filters.priority);

    fetchTasks(props.project, filters);
}, { deep: true });

const onPageChange = async (event) => {
    const page = event.page + 1;
    console.log(page)
    filters.page = page;
    await fetchTasks(props.project, filters);
};

const renderTaskShow = (task) =>
    router.get(`/projects/${props.project.id}/tasks/${task.id}`)

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

const isPastDate = (dateString) => {
    if (!dateString) return false;

    const date = new Date(dateString);
    date.setHours(0, 0, 0, 0); // 時間を0時0分0秒0ミリ秒に設定
    const today = new Date();
    today.setHours(0, 0, 0, 0); // 同じく現在日時も0時0分0秒0ミリ秒に設定

    return date < today;
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

            <div class="flex flex-col w-full sm:px-6 lg:px-8 px-12">
                <div class="p-6 text-gray-900">
                    <p>課題一覧</p>
                    <div class="my-5">
                        <label>担当者</label>
                        <select v-model="filters.user_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-1 mr-5">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">全て</option>
                            <option v-for="projectUser in props.project_users" :value="projectUser.id">
                                {{ projectUser.name }}
                            </option>
                        </select>
                        <label>状態</label>
                        <select v-model="filters.status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-1 mr-5">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">全て</option>
                            <option value="未対応">未対応</option>
                            <option value="処理中">処理中</option>
                            <option value="処理済み">処理済み</option>
                            <option value="完了">完了</option>
                            <option value="完了以外">完了以外</option>
                        </select>
                        <label>優先度</label>
                        <select v-model="filters.priority"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-1">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">全て</option>
                            <option value="低">低</option>
                            <option value="中">中</option>
                            <option value="高">高</option>
                        </select>
                    </div>

                </div>
                <section class="text-gray-600 body-font ">
                    <div class="container border bg-white">
                        <div class="lg:w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead class="shadow-lg text-green-700">
                                    <tr>
                                        <th
                                            class="px-1 py-3 title-font tracking-wider font-medium text-sm rounded-tl rounded-bl text-center">
                                            タスクNo</th>
                                        <th
                                            class="px-2 py-3 title-font tracking-wider font-medium text-sm rounded-tl rounded-bl text-center">
                                            件名</th>
                                        <th class="px-3 py-3 title-font tracking-wider font-medium text-sm text-center">
                                            担当者</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-sm text-center">
                                            状態</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-sm text-center">
                                            種別</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-sm text-center">
                                            優先度</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-sm text-center">
                                            ブランチ名</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-sm text-center">
                                            開始日</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-sm text-center">
                                            期限日</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-sm text-center">
                                            登録日</th>
                                    </tr>
                                </thead>
                                <tbody v-for="task in tasks" :key="task.id">
                                    <tr class="border-b border-gray-300 hover:bg-blue-200 text-sm"
                                        @click="renderTaskShow(task)">
                                        <td class="px-1 py-3 text-center">{{ task.id }}</td>
                                        <td class="px-2 py-3 w-1/5 text-left">{{ task.title }}</td>
                                        <td class="px-3 py-3 text-center">{{ task.user.name }}</td>
                                        <td class="px-6 py-3 text-center">
                                            <div v-if="task.status === '完了'" class="rounded-full p-1 bg-slate-300">
                                                {{ task.status }}
                                            </div>
                                            <div v-if="task.status === '処理済み'" class="rounded-full p-1 bg-indigo-200">
                                                {{ task.status }}
                                            </div>
                                            <div v-if="task.status === '未対応'" class="rounded-full p-1 bg-orange-200">
                                                {{ task.status }}
                                            </div>
                                            <div v-if="task.status === '処理中'" class="rounded-full p-1 bg-green-300">
                                                {{ task.status }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-center text-white">
                                            <div v-if="task.type">
                                                <div v-if="task.type.name === 'バグ'" class="rounded-full p-1 bg-red-600">
                                                    {{ task.type.name }}
                                                </div>
                                                <div v-if="task.type.name === '実装'" class="rounded-full p-1 bg-blue-600">
                                                    {{ task.type.name }}
                                                </div>
                                                <div v-if="task.type.name === '改善'" class="rounded-full p-1 bg-pink-600">
                                                    {{ task.type.name }}
                                                </div>
                                                <div v-if="task.type.name !== '改善' && task.type.name !== '実装' && task.type.name !== 'バグ'"
                                                    class="rounded-full p-1 bg-slate-500">
                                                    {{ task.type.name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-6 text text-center font-semibold">
                                            <div v-if="task.priority === '高'" class="text-red-600">
                                                {{ task.priority }}
                                            </div>
                                            <div v-if="task.priority === '中'" class="text-green-500">
                                                {{ task.priority }}
                                            </div>
                                            <div v-if="task.priority === '低'" class="text-blue-500">
                                                {{ task.priority }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ task.branch_name }}</td>
                                        <td class="px-4 py-3 text-center">
                                            {{ formatDate(task.start_date) }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div v-if="isPastDate(task.end_date)" class="text-red-500">
                                                {{ formatDate(task.end_date) }}
                                            </div>
                                            <div v-else>
                                                {{ formatDate(task.end_date) }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ formatDate(task.created_at) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <Paginator @page="onPageChange" :rows="20" :totalRecords="pagination.total"
                                :rowsPerPageOptions="rowsPerPageOption"></Paginator>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style></style>
