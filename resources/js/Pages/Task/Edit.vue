<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import TextInput from '@/Components/TextInput.vue'
import { ref, reactive } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
    'project': Object,
    'task': Object,
})

const form = reactive({
    user_id: props.task ? props.task.user_id : null,
    type_id: props.task ? props.task.type_id : null,
    title: props.task ? props.task.title : null,
    content: props.task ? props.task.content : null,
    status: props.task ? props.task.status : null,
    priority: props.task ? props.task.priority : null,
    branch_name: props.task ? props.task.branch_name: null,
    start_date: props.task ? props.task.start_date : null,
    end_date: props.task ? props.task.end_date : null,
})

function updateTask() {
    router.put(`/projects/${props.project.id}/tasks/${props.task.id}`, form)
}

// console.log(props.project);
</script>

<template>
    <!-- <Head :title="project.name" /> -->

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template> -->

        <div class="flex w-full">
            <SideMenu :project="props.project" class="h-screen" />
            <!-- 左側のコンテナ -->
            <div class="p-6 text-gray-900 w-full">
                <form @submit.prevent="updateTask">
                    <div class="m-5">
                        <p>課題の編集</p>
                        <TextInput type="text" v-model="form.title" class="w-full" placeholder="件名"></TextInput>
                    </div>
                    <div class="bg-white p-5 m-5 rounded">
                        <textarea v-model="form.content" rows="12" class="w-full sm:rounded-lg border-gray-300"
                            placeholder="課題の詳細"></textarea>
                            <table class="w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="border-b border-gray-300 py-16 pl-8 text-left">状態</td>
                                    <td class="border-b border-gray-300">
                                        <select v-model="form.status"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                            <option value="未対応">未対応</option>
                                            <option value="処理中">処理中</option>
                                            <option value="処理済み">処理済み</option>
                                            <option value="完了">完了</option>
                                        </select>
                                    </td>
                                    <td class="w-1/12"></td>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300">担当者</td>
                                    <td class="border-b border-gray-300">
                                        <select v-model="form.user_id"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                            <option v-for="projectUser in props.project.users" :key="projectUser.id"
                                                :value="projectUser.id">
                                                {{ projectUser.name }}
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300 py-16">優先度</td>
                                    <td class="border-b border-gray-300">
                                        <select v-model="form.priority"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                            <option value="低">低</option>
                                            <option value="中">中</option>
                                            <option value="高">高</option>
                                        </select>
                                    </td>
                                    <td class="w-1/12"></td>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300">種別</td>
                                    <td class="border-b border-gray-300">
                                        <select v-model="form.type_id"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                            <option v-for="projectType in props.project.types" :key="projectType.id"
                                                :value="projectType.id">
                                                {{ projectType.name }}
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300 py-16">ブランチ名</td>
                                    <td class="border-b border-gray-300">
                                        <TextInput type="text" v-model="form.branch_name" class="m-5 w-4/5"
                                            placeholder="ブランチ名" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-6 pl-8 text-left border-b border-gray-300 py-16">開始日</td>
                                    <td class="border-b border-gray-300">
                                        <VueDatePicker style="width: 80%;" v-model="form.start_date"
                                            :disabled-week-days="[6, 0]" locale="jp" format="yyyy/MM/dd"
                                            model-type="yyyy-MM-dd" :enable-time-picker="false" class="m-5" />
                                    </td>
                                    <td class="w-1/12"></td>
                                    <td class="py-6 pl-8 text-left border-b border-gray-300">終了日</td>
                                    <td class="border-b border-gray-300">
                                        <VueDatePicker style="width: 80%;" v-model="form.end_date"
                                            :disabled-week-days="[6, 0]" locale="jp" format="yyyy/MM/dd"
                                            model-type="yyyy-MM-dd" :enable-time-picker="false" class="m-5" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-right mr-24 mt-10">
                            <PrimaryButton>更新</PrimaryButton>
                        </div>
                        </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.input-class::placeholder {
    opacity: 0.5;
}
</style>
