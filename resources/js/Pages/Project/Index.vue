<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref, reactive } from 'vue';

const showModal = ref(false);

const form = reactive({
    name: null,
    key: null,
});

function storeProject() {
    router.post('/projects', form)
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 flex w-full">
            <!-- 左側のコンテナ -->
            <div class="flex flex-col w-1/2 sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    <p>プロジェクト一覧</p>
                    <button @click="showModal = true" class="text-blue-500">プロジェクト作成</button>
                    <Modal :show="showModal" @close="showModal = false">
                        <h2 class="m-10 text-xl">プロジェクト追加</h2>
                        <form @submit.prevent="storeProject">
                            <div class="m-10">
                                <p>プロジェクト名</p>
                                <textarea name="name" class="w-full" rows="1" v-model="form.name"></textarea>
                            </div>
                            <div class="m-10">
                                <p>プロジェクトキー</p>
                                <textarea name="name" class="w-full" rows="1" v-model="form.key"></textarea>
                            </div>
                            <div class="m-5">
                                <button class="flex mx-auto text-white bg-indigo-400 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-400 rounded text-lg">登録する</button>
                            </div>
                        </form>
                    </Modal>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">
                            プロジェクト一覧中身
                        </div>
                    </div>
                </div>
                <div class="p-6 text-gray-900">自分の課題
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">自分の課題一覧中身</div>
                    </div>
                </div>
            </div>

            <!-- 右側のコンテナ -->
            <div class="flex flex-col w-1/2 sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">最近の更新
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">最近の更新中身</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
