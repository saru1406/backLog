<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import { reactive, ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
    'project': Object,
    'project_users': Array
})

const tasks = ref([]);

const filters = reactive({
    start_date: null,
    group: null,
    status: null,
    range: null
});

console.log(filters.start_date)

const fetchTasks = async (project, filters) => {
    try {
        let url = `/api/projects/${project.id}/gant`;
        const params = new URLSearchParams();

        if (filters.start_date !== null) params.append('start_date', filters.start_date);
        if (filters.status !== null) params.append('status', filters.status);
        if (filters.range !== null) params.append('range', filters.range);
        if (filters.group !== null) params.append('group', filters.group);

        const response = await axios.get(url, { params: params });
        tasks.value = response.data;
        console.log(response.data)
    } catch (error) {
        console.error('An error occurred while fetching data: ', error);
    }
};

onMounted(() => {
    // ページ読み込み時にlocalStorageからデータを取得して適用
    const savedStartDate = localStorage.getItem("gant_start_date");
    const savedRange = localStorage.getItem("gant_range");
    const savedStatus = localStorage.getItem("gant_status");
    const savedGroup = localStorage.getItem("gant_group");

    // localStorageで保持したデータはstringになる為、"null"をnullに変換
    if (savedStartDate === "null") { // 文字列"null"をチェック
        filters.start_date = null; // 実際のnullをセット
    } else {
        filters.start_date = savedStartDate; // それ以外はそのままセット
    }

    if (savedRange === "null") {
        filters.range = null;
    } else {
        filters.range = savedRange;
    }

    if (savedStatus === "null") {
        filters.status = null;
    } else {
        filters.status = savedStatus;
    }

    if (savedGroup === "null") {
        filters.group = null;
    } else {
        filters.group = savedGroup;
    }

    fetchTasks(props.project, filters);
});

watch(filters, () => {
    //フィルターが変更されたときにlocalStorageに保存
    localStorage.setItem("gant_start_date", filters.start_date);
    localStorage.setItem("gant_range", filters.range);
    localStorage.setItem("gant_group", filters.group);
    localStorage.setItem("gant_status", filters.status);

    fetchTasks(props.project, filters);
}, { deep: true });

const renderTaskShow = (task) =>
    router.get(`/projects/${props.project.id}/tasks/${task.id}`)

const row1BarList = ref([
    {
        myBeginDate: "2023-11-15 13:00",
        myEndDate: "2023-11-16 13:00",
        ganttBarConfig: {
            // each bar must have a nested ganttBarConfig object ...
            id: "unique-id-1", // ... and a unique "id" property
            label: "Lorem ipsum dolor"
        }
    }
])
const row2BarList = ref([
    {
        myBeginDate: "2023-11-15 13:00",
        myEndDate: "2023-11-16 13:00",
        ganttBarConfig: {
            id: "another-unique-id-2",
            hasHandles: true,
            label: "Hey, look at me",
            style: {
                // arbitrary CSS styling for your bar
                background: "#e09b69",
                borderRadius: "20px",
                color: "black"
            },
            class: "foo" // you can also add CSS classes to your bars!
        }
    }
])
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
                        <label>開始日</label>
                        <VueDatePicker v-model="filters.start_date" :disabled-week-days="[6, 0]" locale="jp"
                            format="yyyy/MM/dd" model-type="yyyy-MM-dd" :enable-time-picker="false" />
                        <label>表示範囲</label>
                        <select v-model="filters.range"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">未設定</option>
                            <option value=1>1カ月</option>
                            <option value=2>2カ月</option>
                            <option value=3>3カ月</option>
                            <option value=6>6カ月</option>
                        </select>
                        <label>グルーピング</label>
                        <select v-model="filters.group"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">未設定</option>
                            <option value="担当者">担当者</option>
                            <option value="カテゴリー">カテゴリー</option>
                            <option value="親課題">親課題</option>
                        </select>
                        <label>状態</label>
                        <select v-model="filters.status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option value="" disabled selected>選択してください</option>
                            <option :value="null">未設定</option>
                            <option value="未対応">未対応</option>
                            <option value="処理中">処理中</option>
                            <option value="処理済み">処理済み</option>
                            <option value="処理済み">完了</option>
                            <option value="処理済み">完了以外</option>
                        </select>
                    </div>
                </div>
                <section class="text-gray-600 body-font">
                    <div class="container mx-auto">
                        <div class="lg:w-full mx-auto overflow-auto">
                            <div v-for="task in tasks" class="bg-white p-10 my-10">
                                {{ task.user_name }}
                                <!-- <div v-for="item in task.tasks"> -->
                                    <g-gantt-chart :chart-start="`${task.start_date} 00:00`" :chart-end="`${task.end_date} 00:00`"
                                        precision="day" bar-start="myBeginDate" bar-end="myEndDate">
                                        <g-gantt-row label="My row 1" :bars="row1BarList" />
                                        <g-gantt-row label="My row 2" :bars="row2BarList" />
                                    </g-gantt-chart>
                                <!-- </div> -->
                                <div>
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl text-center">
                                                    件名</th>
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
                                        <tbody v-for="item in task.tasks">
                                            <tr class="border-b border-gray-300 hover:bg-blue-200"
                                                @click="renderTaskShow(task)">
                                                <td class="px-4 py-3 w-1/5">{{ item.title }}</td>
                                                <!-- <td class="px-4 py-3">{{ task.user.name }}</td> -->
                                                <td class="px-4 py-3">{{ item.status }}</td>
                                                <td class="px-4 py-3 text-lg">{{ item.priority }}</td>
                                                <td class="px-4 py-3">
                                                    {{ item.start_date }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ item.end_date }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ item.created_at }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
