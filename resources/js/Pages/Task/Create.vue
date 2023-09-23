<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import SideMenu from '@/Components/SideMenu.vue'
import TextInput from '@/Components/TextInput.vue'
import { ref, reactive } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const date = ref();

const form = reactive({
    title: null,
    content: null,
    status: null,
    manager: null,
    priority: null,
    start_date: null,
    end_date: null,
})

function storeTask() {
    router.post('/tasks', form)
}

</script>

<template>
    <!-- <Head :title="project.name" /> -->

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template> -->

        <div class="flex w-full">
            <SideMenu class="h-screen" />
            <!-- 左側のコンテナ -->
            <div class="p-6 text-gray-900 w-full">
                <form @submit.prevent="storeTask">
                    <div class="m-5">
                        <p>課題の追加</p>
                        <TextInput type="text" v-model="form.title" class="w-full" placeholder="件名"></TextInput>
                    </div>
                    <div class="bg-white p-5 m-5">
                        <textarea v-model="form.content" rows="12" class="w-full sm:rounded-lg border-gray-300"
                            placeholder="課題の詳細"></textarea>
                        <div>
                            <label>状態</label>
                            <TextInput type="text" v-model="form.status" class="m-5"></TextInput>
                            <label>担当者</label>
                            <TextInput type="number" v-model="form.manager" class="m-5"></TextInput>
                            <label>優先度</label>
                            <TextInput type="text" v-model="form.priority" class="m-5"></TextInput>
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
