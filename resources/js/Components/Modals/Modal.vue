<template>
  <teleport to="body">
    <div
      v-show="modelValue"
      class="fixed z-50 inset-0 overflow-y-auto"
      tabindex="0"
    >
      <div :class="[containerClass]">
        <transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-300"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
          name="modal-backdrop"
        >
          <XModalBackdrop
            v-show="modelValue"
            @click="closeOnClickOutside"
          />
        </transition>

        <!-- Force to center the modal  -->
        <span
          v-if="!fullscreen"
          aria-hidden="true"
          class="hidden sm:inline-block sm:align-middle sm:h-screen"
        >&#8203;</span>

        <transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-300"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          name="modal"
        >
          <div
            v-show="modelValue"
            v-bind="$attrs"
            :class="[dialogClass]"
            aria-labelledby="modal-headline"
            aria-modal="true"
            role="dialog"
          >
            <!-- Header -->
            <div
              v-if="$slots.header || title !== ''"
              :class="{'border-b dark:border-gray-700': divided}"
              class="px-4 py-5 sm:px-6 text-gray-700 card-title"
            >
              <slot
                :close="close"
                name="header"
              >
                <h3
                  class="modal-title"
                  v-html="title"
                />
              </slot>
            </div>
            <!-- Body -->
            <div>
              <slot :close="close" />
            </div>
            <!-- Footer -->
            <x-modal-footer
              v-if="$slots.footer"
              ref="footer"
              :divided="divided"
            >
              <slot
                :close="close"
                name="footer"
              />
            </x-modal-footer>
          </div>
        </transition>
      </div>
    </div>
  </teleport>
</template>
<script>
import XModalBackdrop from "./Backdrop";
import XModalFooter from "@/Components/Modals/Footer";

export default {
    name: 'XModal',
    components: {
        XModalFooter,
        XModalBackdrop,
    },
    props: {
        title: {
            type: [String, Number],
            default: '',
        },
        fullscreen: {
            type: Boolean,
            default: false,
        },
        closeable: {
            type: Boolean,
            default: true,
        },
        closeableOnClickOutside: {
            type: Boolean,
            default: true,
        },
        closeableOnPressEscape: {
            type: Boolean,
            default: true,
        },
        containerClass: {
            type: String,
            default: 'flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0',
        },
        modalClass: {
            type: String,
            default: "inline-block align-bottom bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full divide-y divide-y-gray-200",
        },
        divided: {
            type: Boolean,
            default: true,
        },
        modelValue: {
            default: false,
        },
    },
    emits: [
        'close',
        'update:modelValue'
    ],
    computed: {
        dialogClass() {
            if (this.fullscreen) {
                return "flex flex-col block left-0 top-0 w-full h-full divide-y divide-y-gray-200";
            }
            return 'max-w-sm w-full inline-block align-bottom bg-white dark:bg-gray-750 rounded-lg shadow-lg overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-sm sm:w-full dark:border dark:border-gray-700';
        },
    },
    watch: {
        'modelValue': {
            immediate: false,
            handler(value) {
                if(value){
                    document.documentElement.style.overflow = 'hidden'
                }else{
                    document.documentElement.style.overflow = 'auto'
                }
            }
        },
    },
    beforeUnmount() {
        document.removeEventListener('keydown', this.closeOnEscape)
        document.body.style.overflow = null
    },
    mounted() {
        document.addEventListener('keydown', this.closeOnEscape)
        // Ensure we set the amount of items in footer
        if (this.$slots.footer) {
            this.footerItemsCount = this.$refs.footer.children?.length || 0;
        }
    },
    methods: {
        closeOnEscape(e){
            if (this.closeableOnPressEscape && e.key === 'Escape' && this.modelValue) {
                this.close()
            }
        },
        closeOnClickOutside(timeout){
            if(this.closeableOnClickOutside){
                this.close(timeout);
            }
        },
        close(timeout) {
            if (timeout === undefined) {
                timeout = 0;
            }

            if (this.closeable) {
                setTimeout(() => {
                    this.$emit('close')
                }, timeout);
            }
        }
    },
};
</script>
