<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import { reactive, ref, watch, computed, onMounted } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import draggable from 'vuedraggable';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Editor from 'primevue/editor';
import TextInput from '@/Components/TextInput.vue'

const showModal = ref(false);

const showChildModal = ref(false);

const props = defineProps({
    'project': Object,
})

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
    router.post(`/projects/${props.project.id}/tasks/${selectedTask.value.id}/child-tasks`, form)
    // 保存が成功した後にフォームをリセット
    form.user_id = null;
    form.title = null;
    form.content = null;
    form.status = null;
    form.priority = null;
    form.start_date = null;
    form.end_date = null;
}


const tasks = ref([]);
const selectedTask = ref(null);
const childTasks = ref([]);

const filters = reactive({
    user_id: null,
    status: null,
    priority: null,
});

const draggedTask = ref(null);

const handleDragStart = (task) => {
    draggedTask.value = task;
};

const handleDrop = (status) => {
    if (draggedTask.value) {
        draggedTask.value.status = status;
        if (draggedTask.value.task_id) {
            updateChildTask(draggedTask.value.id, status)
        } else {
            updateTask(draggedTask.value.id, status)
        }
        draggedTask.value = null;
    }
};

const allowDrop = (event) => {
    event.preventDefault();
};

const updateTask = async (taskId, status) => {
    try {
        let url = ` /api/projects/${props.project.id}/tasks/${taskId}/update`;
        const params = new URLSearchParams();
        const response = await axios.patch(url, { status: status });
    } catch (error) {
        console.error('APIエラー: ', error);
    }
};

const updateChildTask = async (childTaskId, status) => {
    try {
        let url = ` /api/projects/${props.project.id}/child-tasks/${childTaskId}/update`;
        const params = new URLSearchParams();
        const response = await axios.patch(url, { status: status });
    } catch (error) {
        console.error('APIエラー: ', error);
    }
};

const fetchTasks = async (project, filters) => {
    try {
        let url = `/api/projects/${project.id}/tasks`;
        const params = new URLSearchParams();

        if (filters.user_id !== null) params.append('user_id', filters.user_id);
        if (filters.status !== null) params.append('status', filters.status);
        if (filters.priority !== null) params.append('priority', filters.priority);
        params.append('is_pagination', 'false');

        const response = await axios.get(url, { params: params });
        console.log(response.data)
        tasks.value = response.data;
    } catch (error) {
        console.error('APIエラー: ', error);
    }
};

const fetchChildTasks = async (project, filters) => {
    try {
        let url = `/api/projects/${project.id}/child-tasks`;
        const params = new URLSearchParams();

        if (filters.user_id !== null) params.append('user_id', filters.user_id);
        if (filters.status !== null) params.append('status', filters.status);
        if (filters.priority !== null) params.append('priority', filters.priority);

        const response = await axios.get(url, { params: params });
        console.log(response.data)
        childTasks.value = response.data;
    } catch (error) {
        console.error('APIエラー: ', error);
    }
};

onMounted(() => {
    // ページ読み込み時にlocalStorageからデータを取得して適用
    const savedUserId = localStorage.getItem("board_user_id");
    const savedStatus = localStorage.getItem("board_status");
    const savedPriority = localStorage.getItem("board_priority");

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
        fetchTasks(props.project, filters);
    }
});

watch(filters, () => {
    //フィルターが変更されたときにlocalStorageに保存
    localStorage.setItem("board_user_id", filters.user_id);
    localStorage.setItem("board_status", filters.status);
    localStorage.setItem("board_priority", filters.priority);

    fetchTasks(props.project, filters);
    fetchChildTasks(props.project, filters);
}, { deep: true });


const openModalWithTask = (task) => {
    selectedTask.value = task;
    showModal.value = true;
};

computed(() => selectedTask.value);

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

function storeBranchGpt(taskId) {
    try {
        // isLoading.value = true; // ローディング開始
        router.post(`/projects/${props.project.id}/tasks/${taskId}/create-branch-gpt`);

        // 成功時の処理
    } catch (error) {
        // エラー処理
        console.error('エラーが発生しました:', error);
    } finally {
        fetchTasks(props.project, filters);
    }
}

function deleteTask(taskId) {
    router.delete(`/projects/${props.project.id}/tasks/${taskId}`)
}

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
                    <p>ボード</p>
                    <label>担当者</label>
                    <select v-model="filters.user_id"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-1 mr-5">
                        <option value="" disabled selected>選択してください</option>
                        <option :value="null">全て</option>
                        <option v-for="projectUser in props.project.users" :value="projectUser.id">
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
                <div class="flex space-x-4">
                    <div class="rounded px-4 py-2 text-gray-900 bg-white overflow-y-auto min-h-730px max-h-730px min-w-375px border border-gray-200"
                        @drop="handleDrop('未対応')" @dragover="allowDrop($event)">
                        <h3 class="text-center rounded-full p-1 bg-orange-200 sticky top-0">未対応</h3>
                        <draggable v-model="tasks" item-key="id" class="space-y-4" drag-class="dragClass"
                            :options="{ forceFallback: true }">
                            <template #item="{ element }">
                                <div v-if="element.status === '未対応'">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(element)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(element)">
                                            <div class="flex items-center text-center text-white text-xs my-1">
                                                <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                                <div v-if="element.type">
                                                    <div v-if="element.type.name === 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-red-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name === '実装'"
                                                        class="rounded-full px-3 py-1 bg-blue-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name === '改善'"
                                                        class="rounded-full px-3 py-1 bg-pink-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name !== '改善' && element.type.name !== '実装' && element.type.name !== 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-slate-500 ml-5">{{
                                                            element.type.name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ element.title }}
                                            </div>
                                            <div class="mx-3">
                                                担当者: {{ element.user.name }}<br />
                                                期限: {{ formatDate(element.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                        <draggable v-model="childTasks" item-key="id" class="space-y-4" drag-class="dragClass"
                            :options="{ forceFallback: true }">
                            <template #item="{ element }">
                                <div v-if="element.status === '未対応'">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(element)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(element)">
                                            <div class="flex items-center text-center text-white text-xs my-1">
                                                <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                                <div v-if="element.task.type">
                                                    <div v-if="element.task.type.name === 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-red-600 ml-5">{{ element.task.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.task.type.name === '実装'"
                                                        class="rounded-full px-3 py-1 bg-blue-600 ml-5">{{
                                                            element.task.type.name }}
                                                    </div>
                                                    <div v-if="element.task.type.name === '改善'"
                                                        class="rounded-full px-3 py-1 bg-pink-600 ml-5">{{
                                                            element.task.type.name }}
                                                    </div>
                                                    <div v-if="element.task.type.name !== '改善' && element.task.type.name !== '実装' && element.task.type.name !== 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-slate-500 ml-5">{{
                                                            element.task.type.name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ element.title }}
                                            </div>
                                            <div class="mx-3">
                                                担当者: {{ element.user.name }}<br />
                                                期限: {{ formatDate(element.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </div>
                    <div class="rounded px-4 py-2 text-gray-900 bg-white overflow-y-auto min-h-730px max-h-730px min-w-375px border border-gray-200"
                        @drop="handleDrop('処理中')" @dragover="allowDrop($event)">
                        <h3 class="text-center rounded-full p-1 bg-green-300 sticky top-0">処理中</h3>
                        <draggable v-model="tasks" item-key="id" class="space-y-4" drag-class="dragClass"
                            :options="{ forceFallback: true }">
                            <template #item="{ element }">
                                <div v-if="element.status === '処理中'">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(element)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(element)">
                                            <div class="flex items-center text-center text-white text-xs my-1">
                                                <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                                <div v-if="element.type">
                                                    <div v-if="element.type.name === 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-red-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name === '実装'"
                                                        class="rounded-full px-3 py-1 bg-blue-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name === '改善'"
                                                        class="rounded-full px-3 py-1 bg-pink-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name !== '改善' && element.type.name !== '実装' && element.type.name !== 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-slate-500 ml-5">{{
                                                            element.type.name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ element.title }}
                                            </div>
                                            <div class="mx-3">
                                                担当者: {{ element.user.name }}<br />
                                                期限: {{ formatDate(element.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                        <draggable v-model="childTasks" item-key="id" class="space-y-4" drag-class="dragClass"
                            :options="{ forceFallback: true }">
                            <template #item="{ element }">
                                <div v-if="element.status === '処理中'">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(element)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(element)">
                                            <div class="flex items-center text-center text-white text-xs my-1">
                                                <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                                <div v-if="element.task.type">
                                                    <div v-if="element.task.type.name === 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-red-600 ml-5">{{ element.task.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.task.type.name === '実装'"
                                                        class="rounded-full px-3 py-1 bg-blue-600 ml-5">{{
                                                            element.task.type.name }}
                                                    </div>
                                                    <div v-if="element.task.type.name === '改善'"
                                                        class="rounded-full px-3 py-1 bg-pink-600 ml-5">{{
                                                            element.task.type.name }}
                                                    </div>
                                                    <div v-if="element.task.type.name !== '改善' && element.task.type.name !== '実装' && element.task.type.name !== 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-slate-500 ml-5">{{
                                                            element.task.type.name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ element.title }}
                                            </div>
                                            <div class="mx-3">
                                                担当者: {{ element.user.name }}<br />
                                                期限: {{ formatDate(element.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </div>
                    <div class="rounded px-4 py-2 text-gray-900 bg-white overflow-y-auto min-h-730px max-h-730px min-w-375px border border-gray-200"
                        @drop="handleDrop('処理済み')" @dragover="allowDrop($event)">
                        <h3 class="text-center rounded-full p-1 bg-indigo-200 sticky top-0">処理済み</h3>
                        <draggable v-model="tasks" item-key="id" class="space-y-4" drag-class="dragClass"
                            :options="{ forceFallback: true }">
                            <template #item="{ element }">
                                <div v-if="element.status === '処理済み'">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(element)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(element)">
                                            <div class="flex items-center text-center text-white text-xs my-1">
                                                <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                                <div v-if="element.type">
                                                    <div v-if="element.type.name === 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-red-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name === '実装'"
                                                        class="rounded-full px-3 py-1 bg-blue-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name === '改善'"
                                                        class="rounded-full px-3 py-1 bg-pink-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name !== '改善' && element.type.name !== '実装' && element.type.name !== 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-slate-500 ml-5">{{
                                                            element.type.name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ element.title }}
                                            </div>
                                            <div class="mx-3">
                                                担当者: {{ element.user.name }}<br />
                                                期限: {{ formatDate(element.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                        <draggable v-model="childTasks" item-key="id" class="space-y-4" drag-class="dragClass"
                            :options="{ forceFallback: true }">
                            <template #item="{ element }">
                                <div v-if="element.status === '処理済み'">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(element)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(element)">
                                            <div class="flex items-center text-center text-white text-xs my-1">
                                                <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                                <div v-if="element.task.type">
                                                    <div v-if="element.task.type.name === 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-red-600 ml-5">{{ element.task.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.task.type.name === '実装'"
                                                        class="rounded-full px-3 py-1 bg-blue-600 ml-5">{{
                                                            element.task.type.name }}
                                                    </div>
                                                    <div v-if="element.task.type.name === '改善'"
                                                        class="rounded-full px-3 py-1 bg-pink-600 ml-5">{{
                                                            element.task.type.name }}
                                                    </div>
                                                    <div v-if="element.task.type.name !== '改善' && element.task.type.name !== '実装' && element.task.type.name !== 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-slate-500 ml-5">{{
                                                            element.task.type.name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ element.title }}
                                            </div>
                                            <div class="mx-3">
                                                担当者: {{ element.user.name }}<br />
                                                期限: {{ formatDate(element.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </div>
                    <div class="rounded px-4 py-2 text-gray-900 bg-white overflow-y-auto min-h-730px max-h-730px min-w-375px border border-gray-200"
                        @drop="handleDrop('完了')" @dragover="allowDrop($event)">
                        <h3 class="text-center rounded-full p-1 bg-slate-300 sticky top-0">完了</h3>
                        <draggable v-model="tasks" item-key="id" class="space-y-4" drag-class="dragClass"
                            :options="{ forceFallback: true }">
                            <template #item="{ element }">
                                <div v-if="element.status === '完了'">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(element)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(element)">
                                            <div class="flex items-center text-center text-white text-xs my-1">
                                                <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                                <div v-if="element.type">
                                                    <div v-if="element.type.name === 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-red-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name === '実装'"
                                                        class="rounded-full px-3 py-1 bg-blue-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name === '改善'"
                                                        class="rounded-full px-3 py-1 bg-pink-600 ml-5">{{ element.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.type.name !== '改善' && element.type.name !== '実装' && element.type.name !== 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-slate-500 ml-5">{{
                                                            element.type.name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ element.title }}
                                            </div>
                                            <div class="mx-3">
                                                担当者: {{ element.user.name }}<br />
                                                期限: {{ formatDate(element.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                        <draggable v-model="childTasks" item-key="id" class="space-y-4" drag-class="dragClass"
                            :options="{ forceFallback: true }">
                            <template #item="{ element }">
                                <div v-if="element.status === '完了'">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(element)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(element)">
                                            <div class="flex items-center text-center text-white text-xs my-1">
                                                <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                                <div v-if="element.task.type">
                                                    <div v-if="element.task.type.name === 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-red-600 ml-5">{{ element.task.type.name
                                                        }}
                                                    </div>
                                                    <div v-if="element.task.type.name === '実装'"
                                                        class="rounded-full px-3 py-1 bg-blue-600 ml-5">{{
                                                            element.task.type.name }}
                                                    </div>
                                                    <div v-if="element.task.type.name === '改善'"
                                                        class="rounded-full px-3 py-1 bg-pink-600 ml-5">{{
                                                            element.task.type.name }}
                                                    </div>
                                                    <div v-if="element.task.type.name !== '改善' && element.task.type.name !== '実装' && element.task.type.name !== 'バグ'"
                                                        class="rounded-full px-3 py-1 bg-slate-500 ml-5">{{
                                                            element.task.type.name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ element.title }}
                                            </div>
                                            <div class="mx-3">
                                                担当者: {{ element.user.name }}<br />
                                                期限: {{ formatDate(element.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal :show="showModal" @close="showModal = false" :maxWidth="'3xl'">
        <div class="bg-gray-100">
            <div class="p-10">
                <div class="h-auto bg-white p-4 rounded border border-gray-200">
                    <div>
                        <p class="font-semibold p-5">タイトル</p>
                        <p class="font-semibold p-5">{{ selectedTask.title }}</p>
                        <hr>
                    </div>
                    <div>
                        <p class="font-semibold p-5">詳細</p>
                        <p class="p-5">{{ selectedTask.content }}</p>
                        <hr>
                    </div>
                    <table class="w-full text-sm">
                        <tbody>
                            <tr>
                                <td class="border-b border-gray-300 py-8 pl-8 text-left w-1/6">状態</td>
                                <td class="border-b border-gray-300 w-80">
                                    <span v-if="selectedTask.status === '完了'" class="rounded-full py-2 px-6 bg-slate-300">
                                        {{ selectedTask.status }}
                                    </span>
                                    <span v-if="selectedTask.status === '処理済み'"
                                        class="rounded-full py-2 px-6 bg-indigo-200">
                                        {{ selectedTask.status }}
                                    </span>
                                    <span v-if="selectedTask.status === '未対応'" class="rounded-full py-2 px-6 bg-orange-200">
                                        {{ selectedTask.status }}
                                    </span>
                                    <span v-if="selectedTask.status === '処理中'" class="rounded-full py-2 px-6 bg-green-300">
                                        {{ selectedTask.status }}
                                    </span>
                                </td>
                                <td class="w-1/12"></td>
                                <td class="py-3 pl-8 text-left border-b border-gray-300 w-1/6">担当者</td>
                                <td class="border-b border-gray-300 w-80">{{ selectedTask.user.name }}</td>
                            </tr>
                            <tr>
                                <td class="py-3 pl-8 text-left border-b border-gray-300 py-8 w-1/6">優先度</td>
                                <td v-if="selectedTask.priority === '高'"
                                    class="text-lg text-red-600 border-b border-gray-300">
                                    {{ selectedTask.priority }}
                                </td>
                                <td v-if="selectedTask.priority === '中'"
                                    class="text-lg text-green-500 border-b border-gray-300">
                                    {{ selectedTask.priority }}
                                </td>
                                <td v-if="selectedTask.priority === '低'"
                                    class="text-lg text-blue-500 border-b border-gray-300">
                                    {{ selectedTask.priority }}
                                </td>
                                <td class="w-1/12"></td>
                                <td class="py-3 pl-8 text-left border-b border-gray-300">種別</td>
                                <td v-if="selectedTask.type" class="border-b border-gray-300">
                                    <span v-if="selectedTask.type.name === 'バグ'"
                                        class="rounded-full py-2 px-6 bg-red-600 text-white text-xs">
                                        {{ selectedTask.type.name }}
                                    </span>
                                    <span v-if="selectedTask.type.name === '実装'"
                                        class="rounded-full py-2 px-6 bg-blue-600 text-white text-xs">
                                        {{ selectedTask.type.name }}
                                    </span>
                                    <span v-if="selectedTask.type.name === '改善'"
                                        class="rounded-full py-2 px-6 bg-pink-600 text-white text-xs">
                                        {{ selectedTask.type.name }}
                                    </span>
                                    <span
                                        v-if="selectedTask.type.name !== '改善' && selectedTask.type.name !== '実装' && selectedTask.type.name !== 'バグ'"
                                        class="rounded-full py-2 px-6 bg-slate-500 ml-10 text-white text-xs">
                                        {{ selectedTask.type.name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3 pl-8 text-left border-b border-gray-300 py-8">ブランチ名</td>
                                <td class="border-b border-gray-300">
                                    <span class="">{{ selectedTask.branch_name }}</span>
                                    <button v-if="!selectedTask.branch_name" @click="storeBranchGpt"
                                        class="text-sm inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        GPTでブランチ名を自動作成
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-8 text-left border-b border-gray-300 py-8">開始日</td>
                                <td class="border-b border-gray-300 text-base">{{ formatDate(selectedTask.start_date) }}
                                </td>
                                <td class="w-1/12"></td>
                                <td class="pl-8 text-left border-b border-gray-300">終了日</td>
                                <td class="border-b border-gray-300 text-base">{{ formatDate(selectedTask.end_date) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end my-5">
                    <Link :href="route('projects.tasks.edit', { project: project, task: selectedTask })"
                        class="mx-6 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    編集
                    </Link>
                    <div @click="deleteTask(selectedTask.id)" style="cursor: pointer;"
                        class="text-right inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        タスク削除
                    </div>
                </div>
                <div class="h-auto mt-10 bg-white p-4 rounded border border-gray-200">
                    <div class="flex">
                        <button @click="showChildModal = true"
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
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                    担当者</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                    状態</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                    優先度</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                    開始日</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                    期限日</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-sm bg-gray-100 text-center">
                                    登録日</th>
                            </tr>
                        </thead>
                        <tbody v-for="childTask in props.child_tasks" :key="childTask.id">
                            <tr class="border-b border-gray-300 hover:bg-blue-200" @click="renderChildTaskShow(childTask)">
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
    </Modal>
    <Modal :show="showChildModal" @close="showChildModal = false" :maxWidth="'xl'">
        <div class="p-6 text-gray-900 w-full">
            <form @submit.prevent="storeChildTask">
                <div class="m-5">
                    <p>子課題の追加</p>
                    <TextInput type="text" v-model="form.title" class="w-full" placeholder="件名"></TextInput>
                </div>
                <div class="bg-white p-5 m-5">
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
                            <option v-for="projectUser in props.project.users" :key="projectUser.id"
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
                        <VueDatePicker v-model="form.start_date" :disabled-week-days="[6, 0]" locale="jp" />
                    </div>
                    <div class="w-1/2 m-5">
                        <label>終了日</label>
                        <VueDatePicker v-model="form.end_date" :disabled-week-days="[6, 0]" locale="jp" />
                    </div>
                </div>
                <div class="text-center">
                    <PrimaryButton>追加</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
<style>
.dragClass {
    opacity: 1 !important;
}</style>
