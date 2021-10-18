<template>
  <app-authentication-card :with-social-footer="false">
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      {{ $t('auth.verify-email-text') }}
    </div>

    <div
      v-if="verificationLinkSent"
      class="mb-4 font-medium text-sm text-green-600"
    >
      {{ $t('auth.verify-email-sent') }}
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 flex items-center justify-between">
        <button-loading
          :loading="form.processing"
          class="w-full flex justify-center"
          type="submit"
        >
          {{ $t('auth.reset-action-again') }}
        </button-loading>

        <inertia-link
          :href="route('logout')"
          as="button"
          class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
          method="post"
        >
          {{ $t('auth.logout-action') }}
        </inertia-link>
      </div>
    </form>
  </app-authentication-card>
</template>

<script>
import AppAuthenticationCard from '@/Layouts/Backend/Partials/AppAuthenticationCard'
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    components: {
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
            form: useForm({})
        }
    },
    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('verification.send'))
        },
    }
}
</script>
