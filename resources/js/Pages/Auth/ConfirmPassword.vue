<template>
  <app-authentication-card
    :with-heading="false"
    :with-social-footer="false"
  >
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      {{ $t('auth.password-confirm-title') }}
    </div>

    <x-form-errors-group class="mb-4" />

    <form @submit.prevent="submit">
      <x-form-container>
        <x-input-password
          v-model="form.password"
          :errors="form.errors.password"
          :label="$t('passwords.fields.password')"
          :placeholder="$t('placeholders.password')"
          autocomplete="current-password"
          layout="naked"
          name="password"
          required
        />
      </x-form-container>

      <div class="flex justify-end mt-4">
        <button-loading
          :loading="form.processing"
          class="w-full flex justify-center"
          type="submit"
        >
          {{ $t('app.confirm',{name: ''}) }}
        </button-loading>
      </div>
    </form>
  </app-authentication-card>
</template>

<script>
import AppAuthenticationCard from '@/Layouts/Backend/Partials/AppAuthenticationCard'
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import {useForm} from "@inertiajs/inertia-vue3";
import XFormContainer from "@/Components/Forms/Container";
import XInputPassword from "@/Components/Inputs/Password";
import XFormErrorsGroup from "@/Components/Forms/ErrorsGroup";

export default {
    components: {
        XFormErrorsGroup,
        XInputPassword,
        XFormContainer,
        ButtonLoading,
        AppAuthenticationCard,
    },

    data() {
        return {
            form: useForm({
                password: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.confirm'), {
                onFinish: () => this.form.reset(),
            })
        }
    }
}
</script>
