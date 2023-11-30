<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import { reactive, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    'project': Object,
    'project_users': Array,
    'project_not_users': Array
})

const form = ref('')

// const form = reactive({
//     user: null
// })

function store_project_user(){
    router.post(`/projects/${props.project.id}/user`, { user_id: form.value })
}

</script>

<template>
    <Head :title="project.name" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template> -->

        <div class="flex w-full">
            <SideMenu :project="project" class="h-screen"/>
            <!-- 左側のコンテナ -->
                <div class="flex flex-col w-3/5 sm:px-6 lg:px-8 py-12">
                    <p>プロジェクトに追加するユーザー</p>
                    <form @submit.prevent="store_project_user">
                        <select v-model="form" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-5">
                            <option v-for="user in props.project_not_users" :key="user.id" :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                        <PrimaryButton>追加</PrimaryButton>
                    </form>
                    <div class="p-6 text-gray-900">
                        <p>参加ユーザー</p>
                        <div v-for="project_user in project_users" class="bg-white overflow-hidden shadow-sm p-5 rounded-md">
                            <p class="pl-10">{{ project_user.name }}</p>
                            <hr>
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
