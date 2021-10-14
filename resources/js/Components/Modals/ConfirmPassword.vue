<template>
  <div>
    <div @click="startConfirmingPassword">
      <slot />
    </div>

    <teleport to="body">
      <!-- Confirm Password Modal -->
      <x-modal
        v-model="confirmingPassword"
        :title="title || $t('passwords.confirm-password-title')"
        @close="confirmingPassword = false"
      >
        <form @submit.prevent="confirmPassword">
          <x-form-container>
            <p class="form-content text-xs">
              {{ content || $t('passwords.confirm-password-text') }}
            </p>

            <x-input-password
              v-model="form.password"
              :errors="form.errors.password"
              :label="$t('passwords.fields.current-password')"
              :name="'confirm_current_password'+Math.random().toString(36).slice(2)"
              :placeholder="$t('placeholders.password_current')"
              autocomplete="password"
              required
            />
          </x-form-container>

          <x-modal-footer>
            <button-loading
              :invalid="!form.isDirty"
              :loading="form.processing"
              class="sm:col-start-2 w-full"
              type="submit"
            >
              {{ button || 'Ok, confirmed' }}
            </button-loading>
            <button-primary
              variant="secondary"
              class="sm:col-start-1 w-full sm:mt-0 mt-3"
              type="button"
              @click="confirmingPassword = false"
            >
              {{ buttonCancel || 'Cancel' }}
            </button-primary>
          </x-modal-footer>
        </form>
      </x-modal>
    </teleport>
  </div>
</template>

<script>
import ButtonPrimary from "@/Components/Buttons/ButtonPrimary";
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import XModal from "@/Components/Modals/Modal";
import XFormContainer from "@/Components/Forms/Container";
import {useForm} from "@inertiajs/inertia-vue3";
import XInputPassword from "@/Components/Inputs/Password";
import XModalFooter from "@/Components/Modals/Footer";

export default {
    name: 'XModalConfirmPassword',
    components: {
        XModalFooter,
        XInputPassword,
        XFormContainer,
        XModal,
        ButtonLoading,
        ButtonPrimary,
    },
    props: {
        title: {
            type: String,
            default: null,
        },
        content: {
            type: String,
            default: null,
        },
        button: {
            type: String,
            default: null,
        },
        buttonCancel: {
            type: String,
            default: null
        },
        buttonVariant: {
            type: String,
            default: 'primary',
        },
        force: {
            type: Boolean,
            default: false,
        }
    },
    emits: ['confirmed'],
    data() {
        return {
            confirmingPassword: false,
            form: useForm({password: ''}, {bag: 'confirmPassword'})
        }
    },

    methods: {
        startConfirmingPassword() {
            if (this.force) {
                this.confirmingPassword = true;
                this.form.password = '';
            } else {
                this.axios
                    .get('/user/confirmed-password-status')
                    .then(response => {
                        if (!this.force && response.data.confirmed) {
                            this.confirmingPassword = false;
                            this.$emit('confirmed');
                        } else {
                            this.confirmingPassword = true;
                            this.form.password = '';
                            if (this.$refs.password) {
                                setTimeout(() => {
                                    this.$refs.password.focus()
                                }, 250)
                            }
                        }
                    })
            }
        },
        confirmPassword() {
            this.form.processing = true;
            this.axios.post('/user/confirm-password', {
                password: this.form.password,
            }).then(response => {
                this.confirmingPassword = false;
                this.form.processing = false;
                this.$emit('confirmed', this.form.password);
                this.form.password = '';
            }).catch(error => {
                this.form.processing = false;
                this.form.password = '';
                this.form.errors = {
                    password: [
                        error.response.data.errors.password[0]
                    ]
                }
            });
        }
    }
}
</script>
