<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
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
    user.value = ''
}

function store_project_type() {
    router.post(`/projects/${props.project.id}/type`, { type_name: type.value })
    type.value = ''
}

function deleteProject() {
    router.delete(`/projects/${props.project.id}`)
}

function deleteType(typeId) {
    router.delete(`/projects/${props.project.id}/type/${typeId}`)
}

function deleteUser(userId) {
    router.delete(`/projects/${props.project.id}/user/${userId}`)
}

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
            <div class="flex flex-col w-1/2 sm:px-6 lg:px-8 py-12 ml-72">
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
                    <div class="bg-white overflow-hidden shadow-sm py-5 px-5 rounded-md border">
                        <table class="w-full">
                            <thead class="text-green-700">
                                <tr>
                                    <th
                                        class="title-font tracking-wider font-medium text-sm rounded-tl rounded-bl text-center w-11/12">
                                        メンバー</th>
                                    <th
                                        class="title-font tracking-wider font-medium text-sm rounded-tl rounded-bl text-center w-1">
                                        削除</th>
                                </tr>
                            </thead>
                            <tbody v-for="projectUser in props.project.users" :key="projectUser.id">
                                <tr class="border-b border-gray-300 text-sm">
                                    <td class="px-4 py-3 text-center">{{ projectUser.name }}</td>
                                    <td style="cursor: pointer;" @click="deleteUser(projectUser.id)" class="text-center font-semibold text-red-500">x
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                    <div class="bg-white overflow-hidden shadow-sm py-5 px-5 rounded-md border">
                        <table class="w-full">
                            <thead class="text-green-700">
                                <tr>
                                    <th
                                        class="title-font tracking-wider font-medium text-sm rounded-tl rounded-bl text-center w-11/12">
                                        種別名</th>
                                    <th
                                        class="title-font tracking-wider font-medium text-sm rounded-tl rounded-bl text-center w-1">
                                        削除</th>
                                </tr>
                            </thead>
                            <tbody v-for="projectType in props.project.types" :key="projectType.id">
                                <tr class="border-b border-gray-300 text-sm">
                                    <td class="px-4 py-3 text-center">{{ projectType.name }}</td>
                                    <td style="cursor: pointer;" @click="deleteType(projectType.id)" class="text-center font-semibold text-red-500">x
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-10 self-end"> <!-- mt-10は上部のコンテンツとの間隔を調整、self-endは要素をコンテナの右側に配置 -->
                    <div @click="deleteProject"
                        class="text-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 w-56">
                        プロジェクト削除
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
