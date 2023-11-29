<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import { reactive, ref, watch, computed, onMounted } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';

const showModal = ref(false);

const props = defineProps({
    'project': Object,
    'project_users': Array
})


const tasks = ref([]);
const selectedTask = ref(null);

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
        // ここでAPI呼び出しをしてサーバー側のデータも更新できます。
        draggedTask.value = null;
    }
};

const allowDrop = (event) => {
    event.preventDefault();
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
}, { deep: true });


const openModalWithTask = (task) => {
    selectedTask.value = task;
    showModal.value = true;
};

const selectedTaskValue = computed(() => selectedTask.value);

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

            <div class="flex flex-col w-full sm:px-6 lg:px-8 px-12">
                <div class="p-6 text-gray-900">
                    <p>ボード</p>
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
                <div class="flex space-x-4">
                    <div class="rounded px-4 py-2 text-gray-900 bg-white overflow-y-auto min-h-730px max-h-730px min-w-375px" @drop="handleDrop('未対応')" @dragover="allowDrop($event)">
                        <h3 class="text-center rounded-full p-1 bg-orange-200 sticky top-0">未対応</h3>
                        <div v-for="(task, index) in tasks" :key="task.id">
                            <!-- <div v-for="childTask in tasks" :key="childTask.id"> -->
                            <div v-if="task.status === '未対応'">
                                <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(task)" draggable="true">
                                    <button class="text-left" @click="openModalWithTask(task)">
                                        <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                        <div class="mx-3 mb-2 text-sm">
                                            {{ task.title }}
                                        </div>
                                        <div class="mx-3">
                                            担当者: {{ task.user.name }}<br />
                                            期限: {{ formatDate(task.end_date) }}
                                        </div>
                                    </button>
                                </div>
                                <div v-for="childTask in task.child_tasks" :key="childTask.id">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(childTask)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(childTask.id)">
                                            <div class="rounded-full bg-orange-200 w-5 h-5 m-1"></div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ childTask.title.title }}
                                            </div>
                                            <div class="mx-3">
                                                <!-- 担当者: {{ childTask.user.name }}<br /> -->
                                                期限: {{ formatDate(childTask.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="rounded px-4 py-2 text-gray-900 bg-white overflow-y-auto min-h-730px max-h-730px min-w-375px" @drop="handleDrop('処理中')" @dragover="allowDrop($event)">
                        <h3 class="text-center rounded-full p-1 bg-green-300 sticky top-0">処理中</h3>
                        <div v-for="task in tasks" :key="task.id">
                            <div v-if="task.status === '処理中'">
                                <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(task)" draggable="true">
                                    <button class="text-left" @click="openModalWithTask(task)">
                                        <div class="rounded-full bg-green-300 w-5 h-5 m-1"></div>
                                        <div class="mx-3 mb-2 text-sm">
                                            {{ task.title }}
                                        </div>
                                        <div class="mx-3">
                                            担当者: {{ task.user.name }}<br />
                                            期限: {{ formatDate(task.end_date) }}
                                        </div>
                                    </button>
                                </div>
                                <div v-for="childTask in task.child_tasks" :key="childTask.id">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(childTask)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(childTask.id)">
                                            <div class="rounded-full bg-green-300 w-5 h-5 m-1"></div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ childTask.title.title }}
                                            </div>
                                            <div class="mx-3">
                                                <!-- 担当者: {{ childTask.user.name }}<br /> -->
                                                期限: {{ formatDate(childTask.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded px-4 py-2 text-gray-900 bg-white overflow-y-auto min-h-730px max-h-730px min-w-375px" @drop="handleDrop('処理済み')" @dragover="allowDrop($event)">
                        <h3 class="text-center rounded-full p-1 bg-indigo-200 sticky top-0">処理済み</h3>
                        <div v-for="task in tasks" :key="task.id">
                            <div v-if="task.status === '処理済み'">
                                <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(task)" draggable="true">
                                    <button class="text-left" @click="openModalWithTask(task)">
                                        <div class="rounded-full bg-indigo-200 w-5 h-5 m-1"></div>
                                        <div class="mx-3 mb-2 text-sm">
                                            {{ task.title }}
                                        </div>
                                        <div class="mx-3">
                                            担当者: {{ task.user.name }}<br />
                                            期限: {{ formatDate(task.end_date) }}
                                        </div>
                                    </button>
                                </div>
                                <div v-for="childTask in task.child_tasks" :key="childTask.id">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(childTask)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(childTask.id)">
                                            <div class="rounded-full bg-indigo-200 w-5 h-5 m-1"></div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ childTask.title }}
                                            </div>
                                            <div class="mx-3">
                                                <!-- 担当者: {{ childTask.user.name }}<br /> -->
                                                期限: {{ formatDate(childTask.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded px-4 py-2 text-gray-900 bg-white overflow-y-auto min-h-730px max-h-730px min-w-375px" @drop="handleDrop('完了')" @dragover="allowDrop($event)">
                        <h3 class="text-center rounded-full p-1 bg-slate-300 sticky top-0">完了</h3>
                        <div v-for="task in tasks" :key="task.id">
                            <div v-if="task.status === '完了'">
                                <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(task)" draggable="true">
                                    <button class="text-left" @click="openModalWithTask(task)">
                                        <div class="rounded-full bg-slate-300 w-5 h-5 m-1"></div>
                                        <div class="mx-3 mb-2 text-sm">
                                            {{ task.title }}
                                        </div>
                                        <div class="mx-3">
                                            担当者: {{ task.user.name }}<br />
                                            期限: {{ formatDate(task.end_date) }}
                                        </div>
                                    </button>
                                </div>
                                <div v-for="childTask in task.child_tasks" :key="childTask.id">
                                    <div class="border mt-3 shadow rounded" @dragstart="handleDragStart(childTask)"
                                        draggable="true">
                                        <button class="text-left" @click="openModalWithTask(childTask.id)">
                                            <div class="rounded-full bg-slate-300 w-5 h-5 m-1"></div>
                                            <div class="mx-3 mb-2 text-sm">
                                                {{ childTask.title.title }}
                                            </div>
                                            <div class="mx-3">
                                                <!-- 担当者: {{ childTask.user.name }}<br /> -->
                                                期限: {{ formatDate(childTask.end_date) }}
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal :show="showModal" @close="showModal = false">
        <div class="h-[850px] bg-gray-100">
            <div class="p-10">
                <Link :href="route('projects.tasks.edit', { project: project, task: selectedTask })"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                編集</Link>
                <label class="pl-5">開始日</label>{{ formatDate(selectedTaskValue.start_date) }}
                <label class="pl-5">終了日</label>{{ formatDate(selectedTaskValue.end_date) }}
                <div class="h-auto bg-white p-4">
                    <div>
                        <p class="font-semibold p-5">タイトル</p>
                        <p class="p-5">{{ selectedTaskValue.title }}</p>
                        <hr>
                    </div>
                    <div>
                        <p class="font-semibold p-5">詳細</p>
                        <p class="p-5">{{ selectedTaskValue.content }}</p>
                        <hr>
                    </div>
                    <div>
                        <p class="font-semibold p-5">備考</p>
                        <hr>
                        <p class="m-3">優先度</p>{{ selectedTaskValue.priority }}
                        <hr>
                        <p class="m-3">カテゴリー</p>
                        <hr>
                        <p class="m-3">担当者</p>{{ selectedTaskValue.user.name }}
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
