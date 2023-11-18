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

            <div class="flex flex-col w-full sm:px-6 lg:px-8 py-12">
                <div class="p-6 text-gray-900">
                    <p>ボード</p>
                    <div>
                        <label>担当者</label>
                        <select v-model="filters.user_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">未設定</option>
                            <option v-for="projectUser in props.project_users" :value="projectUser.id">
                                {{ projectUser.name }}
                            </option>
                        </select>
                        <label>状態</label>
                        <select v-model="filters.status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">未設定</option>
                            <option value="未対応">未対応</option>
                            <option value="処理中">処理中</option>
                            <option value="処理済み">処理済み</option>
                            <option value="完了">完了</option>
                            <option value="完了以外">完了以外</option>
                        </select>
                        <label>優先度</label>
                        <select v-model="filters.priority"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">未設定</option>
                            <option value="低">低</option>
                            <option value="中">中</option>
                            <option value="高">高</option>
                        </select>
                    </div>

                </div>
                <section class="text-gray-600 body-font bg-white">
                    <div class="container px-5 py-8 mx-auto">
                        <div class="lg:w-full mx-auto overflow-auto">
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
                                <tbody v-for="task in tasks" :key="task.id">
                                    <tr class="border-b border-gray-300 hover:bg-blue-200" @click="renderTaskShow(task)">
                                        <td class="px-4 py-3 w-1/5">{{ task.title }}</td>
                                        <td class="px-4 py-3">{{ task.user.name }}</td>
                                        <td class="px-4 py-3">{{ task.status }}</td>
                                        <td class="px-4 py-3 text-lg">{{ task.priority }}</td>
                                        <td class="px-4 py-3">
                                            {{ task.start_date }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ task.end_date }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ task.created_at }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <div class="card">
                    <Paginator @page="onPageChange" :rows="20" :totalRecords="pagination.total"
                        :rowsPerPageOptions="rowsPerPageOption"></Paginator>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
