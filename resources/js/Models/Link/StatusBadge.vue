<template>
  <span
    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
    :class="badge.class"
  >
    <component
      :is="badge.icon"
      class="h-3 w-3 mr-1"
    />
    <span>{{ badge.label }}</span>
  </span>
</template>
<script>
import {
    XIcon,
    CheckIcon,
    ShieldCheckIcon
} from "@heroicons/vue/outline";
export default {
    props: {
        status: {
            type: [String, Number],
            required: true,
        },
    },
    computed:{
        badge(){
            return {
            [this.$page.props.guidelines.links.status.rejected]: {
                class: 'bg-red-100 text-red-800',
                icon: XIcon,
                label: this.$t('app.link_status.rejected')
            },
            [this.$page.props.guidelines.links.status.published]: {
                class: 'bg-green-100 text-green-800',
                icon: CheckIcon,
                label: this.$t('app.link_status.published')
            },
            [this.$page.props.guidelines.links.status.waiting_approval]: {
                class: 'bg-yellow-100 text-yellow-800',
                icon: ShieldCheckIcon,
                label: this.$t('app.link_status.waiting-approval')
            },
            }[this.status]
        }
    }
};
</script>
