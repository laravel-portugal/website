<template>
  <div>
    <transition
      leave-active-class="transition ease-in duration-1000"
      leave-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-show="on"
        class="flex text-sm text-gray-600 dark:text-white mr-3"
      >
        <slot name="icon">
          <check-icon
            v-if="type === 'success'"
            class="h-5 w-5 mr-1"
          />
          <x-icon
            v-if="type === 'danger'"
            class="h-5 w-5  mr-1"
          />
          <exclamation-icon
            v-if="type === 'warning'"
            class="h-5 w-5  mr-1"
          />
          <information-circle-icon
            v-if="type === 'info'"
            class="h-5 w-5  mr-1"
          />
        </slot>
        <span>
          <slot>
            Saved
          </slot>
        </span>
      </div>
    </transition>
  </div>
</template>

<script>
import {
    CheckIcon,
    XIcon,
    ExclamationIcon,
    InformationCircleIcon
} from '@heroicons/vue/outline';

export default {
    name: 'XFormActionMessage',
    components: {
        CheckIcon,
        XIcon,
        ExclamationIcon,
        InformationCircleIcon
    },
    props: {
        on: {
            type: [Boolean, String, Number],
            default: false,
            required: false
        },
        type: {
            type: String,
            default: 'success',
            required: false,
        }
    }
}
</script>
