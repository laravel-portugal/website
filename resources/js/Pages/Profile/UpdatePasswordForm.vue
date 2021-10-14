<template>
  <form @submit.prevent="submit()">
    <x-card
      :subtitle="$t('passwords.update-subtitle')"
      :title="$t('passwords.update-title')"
    >
      <x-form-container>
        <div class="hidden">
          <x-input-text
            v-model="username"
            label="username"
            name="username"
            type="hidden"
          />
        </div>

        <x-input-password
          v-model="form.current_password"
          :errors="form.errors.current_password"
          :label="$t('passwords.fields.current-password')"
          :placeholder="$t('placeholders.password_current')"
          autocomplete="current-password"
          name="current_password"
          required
        />

        <x-input-password
          v-model="form.password"
          :errors="form.errors.password"
          :label="$t('passwords.fields.new-password')"
          :placeholder="$t('placeholders.password_new')"
          name="password"
          required
        />

        <x-input-password
          v-model="form.password_confirmation"
          :errors="form.errors.password_confirmation"
          :label="$t('passwords.fields.new-password-confirm')"
          :placeholder="$t('placeholders.password_new_confirmation')"
          name="password_confirmation"
          required
        />
      </x-form-container>

      <!-- Footer -->
      <template #footer>
        <x-form-action-buttons :form="form" />
      </template>
    </x-card>
  </form>
</template>

<script>
import XFormContainer from "@/Components/Forms/Container";
import XInputPassword from "@/Components/Inputs/Password";
import XFormActionButtons from "@/Components/Forms/ActionButtons";
import {useForm} from "@inertiajs/inertia-vue3";
import XInputText from "@/Components/Inputs/Text";
import XCard from "@/Components/Cards/Card";

export default {
    components: {
        XCard,
        XInputText,
        XFormActionButtons,
        XInputPassword,
        XFormContainer,
    },
    data() {
        return {
            username: null,
            form: useForm({
                current_password: '',
                password: '',
                password_confirmation: '',
            })
        }
    },
    methods: {
        submit() {
            this.form.put('/user/password', {
                errorBag: 'updatePassword',
                preserveScroll: true,
                onSuccess: () => this.$refs.current_password.focus(),
            });
        },
    },
}
</script>
