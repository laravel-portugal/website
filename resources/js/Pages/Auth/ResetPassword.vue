<template>
  <app-authentication-card
    :with-heading="false"
    :with-social-footer="false"
  >
    <x-form-errors-group class="mb-4" />

    <form @submit.prevent="submit">
      <x-form-container
        :divide="false"
        :spaced="true"
        body-classes="bg-transparent"
      >
        <x-input-text
          v-model="form.email"
          :errors="form.errors.email"
          :label="$t('users.fields.email')"
          :placeholder="'john@gmail.com'"
          autocomplete="email"
          layout="naked"
          name="email"
          required
          type="email"
        />

        <x-input-password
          v-model="form.password"
          :errors="form.errors.password"
          :label="$t('passwords.fields.password')"
          :placeholder="$t('placeholders.password')"
          autocomplete="new-password"
          layout="naked"
          name="password"
          required
        />

        <x-input-password
          v-model="form.password_confirmation"
          :errors="form.errors.password_confirmation"
          :label="$t('passwords.fields.password-confirm')"
          :placeholder="$t('placeholders.password')"
          autocomplete="new-password-confirmation"
          layout="naked"
          name="password_confirmation"
          required
        />
      </x-form-container>

      <div class="flex items-center justify-end mt-4">
        <button-loading
          :loading="form.processing"
          class="w-full flex justify-center"
          type="submit"
        >
          {{ $t('auth.reset-password-action') }}
        </button-loading>
      </div>
    </form>
  </app-authentication-card>
</template>

<script>
import AppAuthenticationCard from '@/Layouts/Partials/AppAuthenticationCard'
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import XInputPassword from "@/Components/Inputs/Password";
import XFormContainer from "@/Components/Forms/Container";
import XInputText from "@/Components/Inputs/Text";
import {useForm} from "@inertiajs/inertia-vue3";
import XFormErrorsGroup from "@/Components/Forms/ErrorsGroup";

export default {
    components: {
        XFormErrorsGroup,
        XInputText,
        XFormContainer,
        XInputPassword,
        ButtonLoading,
        AppAuthenticationCard,
    },

    props: {
        email: {
            type: String,
            default: '',
        },
        token: {
            type: String,
            default: '',
        },
    },

    data() {
        return {
            form: useForm({
                token: this.token,
                email: this.email,
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.update'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
