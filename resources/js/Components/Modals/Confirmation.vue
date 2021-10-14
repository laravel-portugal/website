<template>
  <x-modal
    v-bind="$attrs"
  >
    <div class="sm:flex sm:items-start px-4 pt-5 pb-4">
      <slot name="icon">
        <div
          class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
        >
          <exclamation-icon class="h-6 w-6 text-red-600" />
        </div>
      </slot>

      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
        <h3 class="modal-title">
          <slot name="title">
            <span
              v-if="title "
              v-html="title"
            />
          </slot>
        </h3>

        <div class="modal-body mt-2">
          <slot name="content">
            <span
              v-if="text"
              v-html="text"
            />
          </slot>
        </div>
      </div>
    </div>

    <template #footer>
      <slot name="footer">
        <button-primary
          variant="secondary"
          class="sm:col-start-2 w-full"
          @click="$emit('canceled')"
        >
          {{ cancelLabel }}
        </button-primary>
        <button-loading
          :loading="form && form.processing"
          class="sm:col-start-1 w-full sm:mt-0 mt-3"
          variant="danger"
          @click="$emit('confirmed')"
        >
          {{ confirmLabel }}
        </button-loading>
      </slot>
    </template>
  </x-modal>
</template>

<script>
import {ExclamationIcon} from '@heroicons/vue/outline';
import XModal from "@/Components/Modals/Modal";
import ButtonPrimary from "@/Components/Buttons/ButtonPrimary";
import ButtonLoading from "@/Components/Buttons/ButtonLoading";

export default {
    name: 'XModalConfirmation',
    components: {
        ButtonLoading,
        ButtonPrimary,
        XModal,
        ExclamationIcon
    },
    props: {
        title: {
            type: [String, Number],
            default: undefined,
            required: false
        },
        text: {
            type: [String, Number],
            default: undefined,
            required: false
        },
        form: {
            type: [Object, Boolean],
            default: false,
            required: false
        },
        confirmText: {
            type: [String, Number],
            default: '',
            required: false
        },
        cancelText: {
            type: [String, Number],
            default: '',
            required: false
        },
    },
    emits: [
        'confirmed',
        'canceled'
    ],
    computed: {
        confirmLabel() {
            return this.confirmText !== '' ? this.confirmText : 'Confirm';
        },
        cancelLabel() {
            return this.cancelText !== '' ? this.cancelText : 'Nevermind';
        }
    },
}
</script>
