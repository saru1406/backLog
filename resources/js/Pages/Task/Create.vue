<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import TextInput from '@/Components/TextInput.vue'
import { reactive } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Editor from 'primevue/editor';

const props = defineProps({
    'project': Object,
    'currentUser': Object,
    'errors': Object
})

const form = reactive({
    user_id: null,
    title: null,
    content: null,
    status: null,
    priority: null,
    branch_name: null,
    start_date: null,
    end_date: null,
    type: null,
})

function storeTask() {
    router.post(`/projects/${props.project.id}/tasks`, form)
    // 保存が成功した後にフォームをリセット
    form.user_id = null;
    form.title = null;
    form.content = null;
    form.status = null;
    form.priority = null;
    form.branch_name = null;
    form.start_date = null;
    form.end_date = null;
}

// console.log(props.project);
</script>

<template>
    <!-- <Head :title="project.name" /> -->

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト名：{{ props.project.name }}</h2>
        </template> -->

        <div class="flex w-full">
            <SideMenu :project="props.project" class="h-screen" />
            <!-- 左側のコンテナ -->
            <div class="p-6 text-gray-900 w-full ml-72">
                <form @submit.prevent="storeTask">
                    <div class="m-5">
                        <p>課題の追加</p>
                        <TextInput type="text" v-model="form.title" class="w-full" placeholder="件名"></TextInput>
                        <div v-if="errors.title" class="text-red-500">
                            {{ errors.title }}
                        </div>
                    </div>
                    <div class="bg-white p-5 m-5 rounded border border-gray-200">
                        <div class="card">
                            <Editor v-model="form.content" editorStyle="height: 320px" />
                        </div>
                        <table class="w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="border-b border-gray-300 py-16 pl-8 text-left">状態<span
                                            class="text-red-500 text-lg">*</span></td>
                                    <td class="border-b border-gray-300">
                                        <select v-model="form.status"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                            <option value="未対応">未対応</option>
                                            <option value="処理中">処理中</option>
                                            <option value="処理済み">処理済み</option>
                                            <option value="完了">完了</option>
                                        </select>
                                        <div v-if="errors.status" class="text-red-500">
                                            {{ errors.status }}
                                        </div>
                                    </td>
                                    <td class="w-1/12"></td>
                                    <td class="py-3 pl-8 text-left border-b border-gray-300">担当者<span
                                            class="text-red-500 text-lg">*</span></td>
                                    <td class="border-b border-gray-300">
                                        <select v-model="form.user_id"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                            <option v-for="projectUser in props.project.users" :key="projectUser.id"
                                                :value="projectUser.id">
                                                {{ projectUser.name }}
                                            </option>
                                        </select>
                                        <div v-if="errors.user_id" class="text-red-500">
                                            {{ errors.user_id }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-8 text-left border-b border-gray-300 py-16">優先度</td>
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
                                        <select v-model="form.type"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5 w-4/5">
                                            <option v-for="projectType in props.project.types" :key="projectType.id"
                                                :value="projectType.id">
                                                {{ projectType.name }}
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-8 text-left border-b border-gray-300 py-16">ブランチ名</td>
                                    <td class="border-b border-gray-300">
                                        <TextInput type="text" v-model="form.branch_name" class="m-5 w-4/5"
                                            placeholder="ブランチ名" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-8 text-left border-b border-gray-300 py-16">開始日</td>
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
                            <PrimaryButton>追加</PrimaryButton>
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
