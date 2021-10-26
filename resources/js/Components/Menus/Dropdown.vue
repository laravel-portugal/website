<template>
  <div>
    <div @click="toggle">
      <slot name="trigger" />
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div
      v-show="open"
      :class="{'bg-black bg-opacity-50': overlay}"
      class="fixed inset-0 z-40"
      @click="toggle(dismissOnClickOverlay)"
    />

    <transition
      enter-active-class="transition ease-out duration-200"
      enter-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-show="open"
        :class="[widthClass, alignmentClasses]"
        class="z-50 mt-2"
        style="display: none;"
        @click="toggle(dismissOnClickContainer)"
      >
        <div
          :class="contentClasses"
          class="z-50 rounded-md shadow-lg border border-gray-200 dark:border-gray-700"
        >
          <slot />
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
    name: 'XDropdown',
    props: {
        align: {
            type: String,
            default: 'right'
        },
        width: {
            type: [String, Number],
            default: '48'
        },
        contentClasses: {
            type: [Object, Array, String],
            default: () => ['py-1', 'bg-white dark:bg-gray-900']
        },
        overlay: {
            type: Boolean,
            default: false
        },
        dismissOnClickOverlay: {
            type: Boolean,
            default: true
        },
        dismissOnClickContainer: {
            type: Boolean,
            default: true
        }
    },
    emits: ['click'],
    data() {
        return {
            open: false,
            closeOnEscapeListener: (e) => {
                if (this.open && e.keyCode === 27) {
                    this.open = false
                }
            }
        }
    },

    computed: {
        widthClass() {
            return {
                '48': 'w-48',
                '64': 'w-64',
            }[this.width.toString()]
        },

        alignmentClasses() {
            if (this.align === 'left') {
                return 'absolute origin-top-left left-0'
            } else if (this.align === 'right') {
                return 'absolute origin-top-right right-0'
            } else if (this.align === 'center') {
                return 'absolute origin-top-right right-0 left-0 sm:left-auto sm:w-sm'
            } else if (this.align === 'center-full-width') {
                return 'absolute origin-top-right right-0 mx-4 left-0 sm:left-auto sm:w-sm'
            } else {
                return this.align;
            }
        },
    },

    mounted() {
        document.addEventListener('keydown', this.closeOnEscapeListener)
    },

    beforeUnmount() {
        document.removeEventListener('keydown', this.closeOnEscapeListener)
    },

    methods: {
        toggle(when = true) {
            if (when) {
                this.open = !this.open
            }
            this.$emit('click')
        }
    },

}
</script>
