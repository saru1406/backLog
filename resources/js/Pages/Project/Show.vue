<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import { ref, onMounted } from 'vue';


const props = defineProps({
    'project': Object,
})

const tasks = ref('');
const groupedTasks = ref({});

const fetchTasks = async (project) => {
    try {
        let url = `/api/projects/${project.id}/new-tasks`;

        const response = await axios.get(url);
        tasks.value = response.data;
        console.log(response.data)
        groupTasks();
    } catch (error) {
        console.error('An error occurred while fetching data: ', error);
    }
};

const groupTasks = () => {
    const groups = {};
    tasks.value.data.forEach(task => {
        const date = task.created_at.substring(0, 10); // YYYY-MM-DD形式
        if (!groups[date]) {
            groups[date] = []; // 日付がキーの配列を初期化
        }
        groups[date].push(task); // タスクを対応する日付の配列に追加
    });
    groupedTasks.value = groups;
};

onMounted(() => {
    fetchTasks(props.project)
})

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
            <div class="flex flex-col w-3/5 sm:px-6 lg:px-8 py-12 ml-72">
                <div class="p-6 text-gray-900">
                    <p class="font-semibold text-lg my-5">プロジェクトのホーム　: 　最近追加した課題一覧</p>
                    <div class="bg-white overflow-hidden shadow-sm border border-gray-200 rounded">
                        <div class="p-6 text-gray-900 text-center">
                            <div v-for="(tasks, dateKey) in groupedTasks" :key="dateKey">
                                {{ dateKey }}
                                <hr>
                                <div v-for="task in tasks" :key="task.id">
                                    件名：{{ task.title }} <br>
                                    内容：{{ task.content }}
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 右側のコンテナ -->
            <div class="flex flex-col w-2/5 sm:px-6 lg:px-8 py-12">
                <div class="p-6 text-gray-900">状態
                    <div class="bg-white overflow-hidden shadow-sm border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">最近の更新中身</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
