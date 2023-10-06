<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import { reactive, ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';

const showModal = ref(false);

const props = defineProps({
    'project': Object,
    'project_tasks': Object,
    'project_users': Array
})

const tasks = ref([]);
console.log(tasks)

const filters = reactive({
  user_id: null,
  status: null,
  priority: null,
});

const fetchTasks = async (project, filters) => {
    try {
        let url = `/api/projects/${project.id}/tasks`;
        const params = new URLSearchParams();

        if(filters.user_id !== null) params.append('user_id', filters.user_id);
        if(filters.status !== null) params.append('status', filters.status);
        if(filters.priority !== null) params.append('priority', filters.priority);

        const response = await axios.get(url, { params: params });
        tasks.value = response.data;
    } catch (error) {
        console.error('An error occurred while fetching data: ', error);
    }
};

watch(filters, () => {
  fetchTasks(props.project, filters);
}, { deep: true });


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
                            <option v-for="projectUser in props.project_users" :value="projectUser.id">
                            {{ projectUser.name}}
                            </option>
                        </select>
                        <label>状態</label>
                        <select v-model="filters.status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="" disabled selected>選択してください</option>
                            <option value="対応前">対応前</option>
                            <option value="対応中">対応中</option>
                            <option value="完了">完了</option>
                        </select>
                        <label>優先度</label>
                        <select v-model="filters.priority"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="" disabled selected>選択してください</option>
                            <option value="低">低</option>
                            <option value="中">中</option>
                            <option value="高">高</option>
                        </select>
                    </div>

                </div>
                <div class="flex space-x-4">
                    <div class="w-1/2 p-6 text-gray-900 bg-white">
                        <h3>対応前</h3>
                        <div v-for="task in tasks" :key="task.id">
                            <button @click="openModalWithTask(task)">
                                <div v-if="task.status === '対応前'" class="border">
                                    {{ task.title }}<br />
                                    {{ task.end_date }}
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="w-1/2 p-6 text-gray-900 bg-white">
                        <h3>対応中</h3>
                        <div v-for="task in tasks" :key="task.id">
                            <button @click="openModalWithTask(task)">
                                <div v-if="task.status === '対応中'" class="border">
                                    {{ task.title }}<br />
                                    {{ task.user.name }}{{ task.end_date }}
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="w-1/2 p-6 text-gray-900 bg-white">
                        <h3>対応済み</h3>
                        <div v-for="task in tasks" :key="task.id">
                            <button @click="openModalWithTask(task)">
                                <div v-if="task.status === '完了'" class="border">
                                    {{ task.title }}<br />
                                    {{ task.user.name }}
                                    {{ task.end_date }}
                                </div>
                            </button>
                            <Modal :show="showModal" @close="showModal = false">
                                <div class="h-[700px] bg-gray-100">
                                    <div class="p-10">
                                        <p class="font-semibold">{{ selectedTaskValue.title }}</p>
                                        <Link :href="route('projects.tasks.edit', { project: project, task: task })"
                                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        編集</Link>
                                        <label class="pl-5">開始日</label>{{ selectedTaskValue.start_date }}
                                        <label class="pl-5">終了日</label>{{ selectedTaskValue.end_date }}
                                        <div class="h-auto bg-white p-4">
                                            <div>
                                                <p class="p-5">{{ selectedTaskValue.user.name }}</p>
                                                <hr>
                                            </div>
                                            <div>
                                                <p class="font-semibold p-5">概要</p>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
