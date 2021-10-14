<template>
  <button
    type="button"
    @click="show = true"
  >
    <slot name="trigger" />
    <teleport
      v-if="show"
      to="body"
    >
      <div>
        <div
          :class="{'bg-black bg-opacity-50': overlay}"
          style="position: fixed; top: 0; right: 0; left: 0; bottom: 0; z-index: 99998;"
          @click="show = false"
        />
        <div
          ref="dropdown"
          style="position: absolute; z-index: 99999;"
          @click.stop="show = !dismissOnClickOverlay"
        >
          <div
            :class="contentClasses"
            class="top-5 rounded-md shadow-lg border border-gray-200 dark:border-gray-700"
          >
            <slot />
          </div>
        </div>
      </div>
    </teleport>
  </button>
</template>

<script>
import Popper from 'popper.js'
import useFiles from "@/Utils/useFileInputs";
export default {
    name: 'XDropdownPopper',
    props: {
        placement: {
            type: String,
            default: 'bottom-end',
        },
        boundary: {
            type: String,
            default: 'scrollParent',
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
        },
        contentClasses: {
            type: [Object, Array, String],
            default: () => ['py-1', 'bg-white dark:bg-gray-900']
        },
        initialState: {
            type: Boolean,
            default: false,
            required: false
        }
    },
    data() {
        return {
            show: false,
        }
    },
    watch: {
        show(show) {
            if (show) {
                this.$nextTick(() => {
                    this.popper = new Popper(this.$el, this.$refs.dropdown, {
                        placement: this.placement,
                        modifiers: {
                            preventOverflow: {boundariesElement: this.boundary},
                            offset: {offset: '5,5'},
                        },
                    })
                })
            } else if (this.popper) {
                setTimeout(() => this.popper.destroy(), 100)
            }
        },
        initialState: {
            immediate: true,
            handler: function (value) {
                this.show = value;
            }
        },
    },
    mounted() {
        document.addEventListener('keydown', (e) => {
            if (e.keyCode === 27) {
                this.show = false
            }
        })
    },
}
</script>
