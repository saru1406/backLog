<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, reactive } from "vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  category: String,
  content: String,
});

const form = reactive({
  category: props.category,
  content: props.content,
});

function confirmContact() {
  router.post("/contacts", form);
}
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        お問い合わせフォーム
      </h2>
    </template>

    <div class="container mx-auto">
      <div v-if="errorMessage" class="error-message">
        {{ errorMessage }}
      </div>
      <div class="w-full">
        <form @submit.prevent="confirmContact">
          <div class="p-6 text-gray-900">
            カテゴリー
            <TextInput
              v-model="form.category"
              readonly
              class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-1 mr-5 w-2/5"
            >
            </TextInput>
          </div>
          <div class="p-6 text-gray-900">
            お問い合わせ内容
            <textarea
              v-model="form.content"
              readonly
              class="w-full h-96 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            ></textarea>
          </div>
          <div class="text-center">
            <PrimaryButton>送信</PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
