<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import TextInput from '@/Components/TextInput.vue'
import { ref, reactive } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import axios from 'axios';

const props = defineProps({
    'project': Object,
    'project_users': Array,
    'task': Object,
})

const form = reactive({
    user_id: props.task ? props.task.user_id : null,
    title: props.task ? props.task.title : null,
    content: props.task ? props.task.content : null,
    status: props.task ? props.task.status : null,
    priority: props.task ? props.task.priority : null,
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
                        <p>課題の追加</p>
                        <TextInput type="text" v-model="form.title" class="w-full" placeholder="件名"></TextInput>
                    </div>
                    <div class="bg-white p-5 m-5">
                        <textarea v-model="form.content" rows="12" class="w-full sm:rounded-lg border-gray-300"
                            placeholder="課題の詳細"></textarea>
                        <div>
                            <label>状態</label>
                            <select v-model="form.status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                                <option value="対応前">対応前</option>
                                <option value="対応中">対応中</option>
                                <option value="完了">完了</option>
                            </select>
                            <label>担当者</label>
                            <select v-model="form.user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                                <option v-for="projectUser in props.projectUsers" :key="projectUser.id" :value="projectUser.id">
                                    {{ projectUser.name }}
                                </option>
                            </select>
                            <label>優先度</label>
                            <select v-model="form.priority" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
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
        </div>
    </AuthenticatedLayout>
</template>

<style>
.input-class::placeholder {
    opacity: 0.5;
}
</style>