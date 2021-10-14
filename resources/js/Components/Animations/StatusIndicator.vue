<template>
  <div class="relative">
    <!-- Responsive indicators! -->
    <span class="flex h-3 w-3">
      <span
        v-if="pulse"
        :class="[pingClass]"
        class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"
      />
      <span
        :class="[colorClass]"
        class="relative inline-flex rounded-full h-3 w-3"
      />
    </span>
  </div>
</template>
<script>
export default {
    name: "XStatusIndicator",
    props: {
        color: {
            type: [String],
            required: true,
            default: 'green'
        },
        pulse: {
            type: [Boolean],
            required: false,
            default: true
        }
    },
    computed: {
        colorClass() {
            return {
                'green': 'bg-green-500',
                'indigo': 'bg-indigo-500',
                'red': 'bg-red-500',
                'blue': 'bg-blue-500',
            }[this.color]
        },
        pingClass() {
            return {
                'green': 'bg-green-600',
                'indigo': 'bg-indigo-600',
                'red': 'bg-red-600',
                'blue': 'bg-blue-600',
            }[this.color]
        }
    }
}
</script>
