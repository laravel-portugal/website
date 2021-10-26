<template>
  <TransitionRoot
    as="template"
    :show="modelValue"
  >
    <Dialog
      as="div"
      static
      class="fixed inset-0 overflow-hidden"
      :open="modelValue"
      @close="$emit('update:modelValue', false)"
    >
      <div class="absolute inset-0 overflow-hidden">
        <DialogOverlay class="absolute inset-0 bg-gray-600 opacity-75" />

        <div class="fixed inset-y-0 left-0 pr-10 max-w-full flex">
          <TransitionChild
            as="template"
            enter="transform transition ease-in-out duration-500 sm:duration-700"
            enter-from="-translate-x-full"
            enter-to="translate-x-0"
            leave="transform transition ease-in-out duration-500 sm:duration-700"
            leave-from="translate-x-0"
            leave-to="-translate-x-full"
          >
            <div
              :class="[containerClasses]"
              class="relative flex-1 flex flex-col max-w-xs w-full pt-5"
            >
              <slot />
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot
} from '@headlessui/vue'

export default {
    name: 'XSlideOver',
    components: {
        Dialog,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
    },
    props: {
        overlay: {
            type: Boolean,
            default: false
        },
        modelValue: {
            type: Boolean,
            default: false,
        },
        containerClasses: {
            type: String,
            default: 'bg-primary-800',
            required: false,
        }
    },
    emits: [
        'close',
        'update:modelValue'
    ],
    data() {
        return {
            open: false,
            closeOnEscapeListener: (e) => {
                if (this.modelValue && e.keyCode === 27) {
                    this.$emit('update:modelValue', false)
                }
            }
        }
    },
    mounted() {
        document.addEventListener('keydown', this.closeOnEscapeListener)
    },

    beforeUnmount() {
        document.removeEventListener('keydown', this.closeOnEscapeListener)
    },
    methods: {
        close() {
            this.$emit('update:modelValue', false)
        }
    }
}
</script>
