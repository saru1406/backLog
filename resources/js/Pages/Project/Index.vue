<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import { ref, reactive } from "vue";
import TextInput from "@/Components/TextInput.vue";

const showModal = ref(false);
defineProps({
  projects: Array,
});

const form = reactive({
  name: null,
});

function storeProject() {
  router.post("/projects", form);
  showModal.value = false;
}
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        プロジェクト一覧
      </h2>
    </template>

    <div class="flex w-full">
      <div v-if="errorMessage" class="error-message">
        {{ errorMessage }}
      </div>
      <!-- 左側のコンテナ -->
      <div class="flex flex-col w-full sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900">
          <button @click="showModal = true" class="text-blue-500">
            プロジェクト作成
          </button>
          <p>プロジェクト一覧</p>
          <Modal :show="showModal" @close="showModal = false" :maxWidth="'xl'">
            <h2 class="m-10 text-xl">プロジェクト追加</h2>
            <form @submit.prevent="storeProject">
              <div class="m-10">
                <p>プロジェクト名</p>
                <TextInput
                  type="text"
                  class="w-full"
                  v-model="form.name"
                ></TextInput>
              </div>
              <div class="m-5">
                <button
                  class="flex mx-auto text-white bg-indigo-400 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-400 rounded text-lg"
                >
                  登録する
                </button>
              </div>
            </form>
          </Modal>
          <div
            class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200"
          >
            <div
              v-for="project in projects"
              :key="project.id"
              class="p-6 text-gray-900 text-left"
            >
              <Link
                class="text-blue-500"
                :href="route('projects.tasks.index', { project: project })"
              >
                {{ project.name }}
              </Link>
              <hr />
            </div>
          </div>
        </div>
        <!-- <div class="p-6 text-gray-900">自分の課題
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">自分の課題一覧中身</div>
                    </div>
                </div> -->
      </div>

      <!-- 右側のコンテナ -->
      <!-- <div class="flex flex-col w-1/2 sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">最近の更新
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900 text-center">最近の更新中身</div>
                    </div>
                </div>
            </div> -->
    </div>
  </AuthenticatedLayout>
</template>
