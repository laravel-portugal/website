<template>
  <app-authentication-card>
    <template #after-logo>
      <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400 max-w">
        <inertia-link
          :href="route('login')"
          class="font-medium hover:underline"
        >
          {{ $t('auth.login-if-not') }}
        </inertia-link>
      </p>
    </template>

    <x-form-errors-group class="mb-4" />

    <form
      class="space-y-6"
      @submit.prevent="submit"
    >
      <x-form-container
        :divide="false"
        :spaced="true"
        body-classes="bg-transparent"
      >
        <x-input-text
          v-model="form.name"
          :errors="form.errors.name"
          :label="$t('users.fields.name')"
          :placeholder="$t('placeholders.name_person')"
          autocomplete="name"
          autofocus
          layout="naked"
          name="email"
          required
          type="text"
        />

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
          autocomplete="password"
          layout="naked"
          name="password"
          required
        />

        <x-input-password
          v-model="form.password_confirmation"
          :errors="form.errors.password_confirmation"
          :label="$t('passwords.fields.password-confirm')"
          :placeholder="$t('placeholders.password')"
          autocomplete="password_confirmation"
          layout="naked"
          name="password_confirmation"
          required
        />

        <x-input-checkbox
          v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
          v-model="form.terms"
          :errors="form.errors.terms"
          :label="$t('auth.terms-agree',{'terms': route('terms.show'), 'privacy': route('policy.show')})"
          name="terms"
        />
      </x-form-container>

      <div class="flex items-center justify-end mt-4">
        <button-loading
          :loading="form.processing"
          class="w-full flex justify-center"
          type="submit"
        >
          {{ $t('auth.register-action') }}
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
import XInputPassword from "@/Components/Inputs/Password";
import XInputCheckbox from "@/Components/Inputs/Checkbox";
import {useForm} from "@inertiajs/inertia-vue3";
import XFormErrorsGroup from "@/Components/Forms/ErrorsGroup";

export default {
    components: {
        XFormErrorsGroup,
        XInputCheckbox,
        XInputPassword,
        XInputText,
        XFormContainer,
        ButtonLoading,
        AppAuthenticationCard,
    },

    data() {
        return {
            form: useForm({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
