<template>
  <!---:class="{'border border-gray-200 rounded-md border-separate': open}" --->
  <div>
    <a
      :class="classes"
      class="cursor-pointer select-none"
      type="button"
      @click="open = ! open"
    >
      <slot name="trigger" />
      <span class="ml-auto">
        <chevron-up-icon
          v-if="open"
          class="ml-2 h-4 w-5 text-gray-400"
        />
        <chevron-down-icon
          v-if="!open"
          class="ml-2 h-4 w-5 text-gray-400"
        />
      </span>
    </a>

    <!-- Expandable link section, show/hide based on state. -->
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
        class="space-y-1 py-2"
      >
        <slot />
      </div>
    </transition>
  </div>
</template>
<script>
import {ChevronDownIcon,ChevronUpIcon} from "@heroicons/vue/outline";

export default {
    components: {
        ChevronDownIcon,
        ChevronUpIcon
    },
    props: {
        active: {
            type: Boolean,
            required: false,
            default: false,
        }
    },
    data() {
        return {
            open: this.$props.active
        }
    },
    computed: {
        classes() {
            return 'group btn-menu px-2 py-3 w-full';
        }
    }
}
</script>
