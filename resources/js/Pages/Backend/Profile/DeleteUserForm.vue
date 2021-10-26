<template>
  <x-card
    :subtitle="$t('users.delete-subtitle')"
    :title="$t('users.delete-title')"
  >
    <div class="px-4 py-5 sm:p-6 bg-gray-50 dark:bg-gray-800">
      <p class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
        {{ $t('users.delete-warning') }}
      </p>
    </div>

    <template #footer>
      <x-modal-confirm-password
        :button="$t('users.delete-title')"
        :button-variant="'danger'"
        :content="$t('users.delete-confirmation')"
        :force="true"
        :title="$t('users.delete-title')"
        @confirmed="deleteUser"
      >
        <button-loading
          :loading="confirmingUserDeletion"
          type="button"
          variant="danger"
        >
          {{ $t('users.delete-title') }}
        </button-loading>
      </x-modal-confirm-password>
    </template>
  </x-card>
</template>

<script>
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import {useForm} from "@inertiajs/inertia-vue3";
import XModalConfirmPassword from "@/Components/Modals/ConfirmPassword";
import XCard from "@/Components/Cards/Card";

export default {
    components: {
        XCard,
        XModalConfirmPassword,
        ButtonLoading,
    },

    data() {
        return {
            confirmingUserDeletion: false,
            deleting: false,
            form: useForm({password: ''})
        }
    },

    methods: {
        deleteUser(secret) {
            this.form.password = secret;
            this.form.delete(this.route('current-user.destroy'), {
                errorBag: 'deleteUser',
                preserveScroll: true,
                onFinish: () => {
                    this.confirmingUserDeletion = false
                    this.$inertia.hardVisit(this.route('logout').url());
                }
            });
        },
    },
}
</script>
