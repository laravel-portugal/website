<template>
  <x-modal
    v-model="open"
    v-bind="$attrs"
    :closeable-on-press-escape="true"
    @close="open = false"
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
            ✋ You are not authorized
          </slot>
        </h3>

        <div class="modal-body mt-2">
          <slot name="content">
            We are sorry but you are not authorized to perform this action.
          </slot>
        </div>
      </div>
    </div>

    <template #footer>
      <slot name="footer">
        <button-primary
          variant="secondary"
          class="sm:col-start-2 w-full"
          @click="open = false"
        >
          Ok, im sorry boss!
        </button-primary>
      </slot>
    </template>
  </x-modal>
</template>

<script>
import {ExclamationIcon} from '@heroicons/vue/outline';
import XModal from "@/Components/Modals/Modal";
import ButtonPrimary from "@/Components/Buttons/ButtonPrimary";

export default {
    components: {
        ButtonPrimary,
        XModal,
        ExclamationIcon
    },
    data() {
        return {
            open: true,
        }
    },
}
</script>
