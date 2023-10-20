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
import Editor from 'primevue/editor';

const props = defineProps({
    'project': Object,
    'project_users': Array,
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

function storeTask() {
    router.post(`/projects/${props.project.id}/tasks`, form)
    // .then((response) => {
    //     // 保存が成功した後にフォームをリセット
    //     form.title = null;
    //     form.content = null;
    //     form.status = null;
    //     form.manager = null;
    //     form.priority = null;
    //     form.start_date = null;
    //     form.end_date = null;
    // })
    // .catch((error) => {
    //     // エラーハンドリング
    //     console.error(error);
    // });
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
                <form @submit.prevent="storeTask">
                    <div class="m-5">
                        <p>課題の追加</p>
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
                                <option v-for="projectUser in props.project_users" :key="projectUser.id"
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
        </div>
    </AuthenticatedLayout>
</template>

<style>
.input-class::placeholder {
    opacity: 0.5;
}</style>
