<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import { ref } from "vue";

const form = ref("");

function store_company() {
  router.post(`/companies`, { company_name: form.value });
}
</script>

<template>
  <GuestLayout>
    <Head title="Register" />

    <form @submit.prevent="store_company">
      <div>
        <InputLabel for="company_name" value="企業名" />

        <TextInput
          id="company_name"
          type="text"
          class="mt-1 block w-full"
          v-model="form"
          required
          autofocus
          autocomplete="name"
        />

        <!-- <InputError class="mt-2" :message="form.errors.company_name" /> -->
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('login')"
          class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Already registered?
        </Link>

        <PrimaryButton
          class="ml-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Register
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
