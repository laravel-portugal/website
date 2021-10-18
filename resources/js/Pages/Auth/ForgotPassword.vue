<template>
  <app-authentication-card>
    <template #after-logo>
      <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400 max-w">
        <inertia-link
          :href="route('login')"
          class="font-medium hover:underline"
        >
          {{ $t('auth.reset-anymore') }}
        </inertia-link>
      </p>
    </template>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      {{ $t('auth.reset-text') }}
    </div>

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-green-600"
      v-html="status"
    />

    <x-form-errors-group class="mb-4" />

    <form @submit.prevent="submit">
      <x-form-container body-classes="bg-transparent">
        <x-input-text
          v-model="form.email"
          :errors="form.errors.email"
          :label="$t('users.fields.email')"
          :placeholder="'john@gmail.com'"
          autocomplete="email"
          autofocus
          layout="naked"
          name="email"
          required
          type="email"
        />
      </x-form-container>

      <div class="flex items-center justify-end mt-4">
        <button-loading
          :loading="form.processing"
          class="w-full flex justify-center"
          type="submit"
        >
          {{ $t('auth.reset-action') }}
        </button-loading>
      </div>
    </form>
  </app-authentication-card>
</template>

<script>
import AppAuthenticationCard from '@/Layouts/Backend/Partials/AppAuthenticationCard'
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import XFormContainer from "@/Components/Forms/Container";
import XInputText from "@/Components/Inputs/Text";
import {useForm} from "@inertiajs/inertia-vue3";
import XFormErrorsGroup from "@/Components/Forms/ErrorsGroup";

export default {
    components: {
        XFormErrorsGroup,
        XInputText,
        XFormContainer,
        ButtonLoading,
        AppAuthenticationCard,
    },

    props: {
        status: {
            type: String,
            default: '',
        }
    },

    data() {
        return {
            form: useForm({
                email: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.email'))
        }
    }
}
</script>
