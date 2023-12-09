<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    'project': Object,
    'projectNotUsers': Array,
})

const user = ref('')

const type = ref('')

function store_project_user() {
    router.post(`/projects/${props.project.id}/user`, { user_id: user.value })
}

function store_project_type() {
    router.post(`/projects/${props.project.id}/type`, { type_name: type.value })
    type.value = ''
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
            <div class="flex flex-col w-1/2 sm:px-6 lg:px-8 py-12">
                <p>プロジェクトに追加するユーザー</p>
                <form @submit.prevent="store_project_user">
                    <select v-model="user"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                        <option v-for="user in props.projectNotUsers" :key="user.id" :value="user.id">
                            {{ user.name }}
                        </option>
                    </select>
                    <PrimaryButton>追加</PrimaryButton>
                </form>
                <div class="p-6 text-gray-900">
                    <p>参加ユーザー</p>
                    <div class="bg-white overflow-hidden shadow-sm pb-5 px-5 rounded-md">
                        <div v-for="projectUser in props.project.users">
                            <p class="pl-10 pt-5">{{ projectUser.name }}</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 右側のコンテナ -->
            <div class="flex flex-col w-1/2 sm:px-6 lg:px-8 py-12">
                <div class="p-6 text-gray-900">
                    <label>種別の追加</label>
                    <div class="flex">
                        <form @submit.prevent="store_project_type">
                            <TextInput type="text" class="w-50 mr-5" v-model="type"></TextInput>
                            <PrimaryButton>追加</PrimaryButton>
                        </form>
                    </div>
                    <div class="mt-10">種別一覧</div>
                    <div class="bg-white overflow-hidden shadow-sm pb-5 px-5 rounded-md">
                        <div v-for="projectType in props.project.types">
                            <p class="pl-10 pt-5">{{ projectType.name }}</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
