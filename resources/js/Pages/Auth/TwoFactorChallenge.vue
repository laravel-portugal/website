<template>
  <app-authentication-card
    :with-heading="false"
    :with-social-footer="false"
  >
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      <span v-if="!recovery">
        {{ $t('auth.two-factor-mobile-text') }}
      </span>
      <span v-else>
        {{ $t('auth.two-factor-recovery-text') }}
      </span>
    </div>

    <x-form-errors-group class="mb-4" />

    <form @submit.prevent="submit">
      <x-form-container
        :divide="false"
        :spaced="true"
        body-classes="bg-transparent"
      >
        <x-input-text
          v-if="! recovery"
          ref="code"
          v-model="form.code"
          :errors="form.errors.code"
          :label="$t('users.fields.verification_code')"
          :placeholder="$t('placeholders.two-factor-code')"
          autocomplete="one-time-code"
          layout="naked"
          name="code"
          type="text"
          inputmode="numeric"
          required
          autofocus
        />

        <x-input-text
          v-if="recovery"
          ref="recovery_code"
          v-model="form.recovery_code"
          :errors="form.errors.recovery_code"
          :label="$t('users.fields.recovery_code')"
          :placeholder="$t('placeholders.two-factor-code')"
          autocomplete="one-time-code"
          layout="naked"
          name="recovery_code"
          type="text"
          required
          autofocus
        />
      </x-form-container>


      <div class="flex items-center justify-center mt-4">
        <button
          class="text-sm w-full flex justify-center text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-400 underline cursor-pointer"
          type="button"
          @click.prevent="toggleRecovery"
        >
          <span v-if="!recovery">
            {{ $t('auth.two-factor-use-recovery') }}
          </span>
          <span v-else>
            {{ $t('auth.two-factor-use-app') }}
          </span>
        </button>
      </div>

      <div class="flex items-center justify-end mt-4">
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
import AppAuthenticationCard from '@/Layouts/Partials/AppAuthenticationCard'
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import XInputText from "@/Components/Inputs/Text";
import XFormContainer from "@/Components/Forms/Container";
import {useForm} from "@inertiajs/inertia-vue3";
import XFormErrorsGroup from "@/Components/Forms/ErrorsGroup";

export default {
    components: {
        XFormErrorsGroup,
        XFormContainer,
        XInputText,
        ButtonLoading,
        AppAuthenticationCard,
    },

    data() {
        return {
            recovery: false,
            form: useForm({
                code: '',
                recovery_code: '',
            })
        }
    },

    methods: {
        toggleRecovery() {
            this.recovery ^= true

            this.$nextTick(() => {
                if (this.recovery) {
                    this.$refs.recovery_code.$refs.input.focus()
                    this.form.code = '';
                } else {
                    this.$refs.code.$refs.input.focus()
                    this.form.recovery_code = ''
                }
            })
        },

        submit() {
            this.form.post(this.route('two-factor.login'))
        }
    }
}
</script>
