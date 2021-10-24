<template>
  <app-head :title="$t('app.menu_landing.login')" />
  <app-authentication-card>
    <template #after-logo>
      <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400 max-w">
        <inertia-link
          :href="route('register')"
          class="font-medium hover:underline"
        >
          {{ $t('auth.register-if-not') }}
        </inertia-link>
      </p>
    </template>

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-green-600"
    >
      {{ status }}
    </div>

    <form
      class="space-y-6"
      @submit.prevent="submit()"
    >
      <!-- Form Fields-->
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
          autofocus
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
          autocomplete="current-password"
          layout="naked"
          name="password"
          required
        />
      </x-form-container>

      <!-- Forget Password & Remember -->
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <x-input-checkbox
            v-model="form.remember"
            :errors="form.errors.remember"
            :label="$t('auth.login-remember')"
            name="remember"
          />
        </div>

        <div class="text-sm text-right">
          <inertia-link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="font-medium text-primary-600 hover:text-primary-500 dark:text-white dark:hover:underline"
          >
            {{ $t('auth.reset-forgot') }}
          </inertia-link>
        </div>
      </div>

      <!-- Button to Login -->
      <div>
        <button-loading
          :loading="form.processing"
          class="w-full flex justify-center"
          type="submit"
        >
          {{ $t('auth.login-action') }}
        </button-loading>
      </div>
    </form>
  </app-authentication-card>
</template>

<script>
import AppAuthenticationCard from '@/Layouts/Backend/Partials/AppAuthenticationCard'
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import {useForm} from "@inertiajs/inertia-vue3";
import XInputText from "@/Components/Inputs/Text";
import XInputPassword from "@/Components/Inputs/Password";
import XInputCheckbox from "@/Components/Inputs/Checkbox";
import XFormContainer from "@/Components/Forms/Container";
import AppHead from "@/Layouts/Backend/Partials/AppHead";

export default {
    components: {
        AppHead,
        XFormContainer,
        XInputCheckbox,
        XInputPassword,
        XInputText,
        ButtonLoading,
        AppAuthenticationCard,
    },

    props: {
        canResetPassword: {
            type: Boolean,
            default: false,
        },
        status: {
            type: String,
            default: '',
        }
    },

    data() {
        return {
            form: useForm({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form
                .transform(data => ({
                    ...data,
                    remember: this.form.remember ? 'on' : ''
                }))
                .post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
        }
    }
}
</script>
