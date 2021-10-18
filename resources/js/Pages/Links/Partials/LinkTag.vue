<template>
  <inertia-link
    :key="tag.id"
    :href="route('links.public',{tag: tag.slug})"
    class="hover:underline inline-flex mr-1 mb-1"
  >
    <span
      class="inline-flex items-center px-2 py-0.5 rounded text-xxs font-medium"
      :class="tagColor(tag.color)"
    >
      <tag-icon
        class="h-3 w-3"
        :class="tagColor(tag.color)"
      />
      <span>{{ tag.name }}</span>
    </span>
  </inertia-link>
</template>

<script>
import {TagIcon} from "@heroicons/vue/outline";
export default {
    components:{
        TagIcon
    },
    props: {
        tag: {
            type: [Object, Array],
            required: true,
        },
    },
    methods: {
        tagColor(color){
            return {
                'red': 'bg-red-100 text-red-800',
                'blue': 'bg-blue-100 text-blue-800',
                'purple': 'bg-purple-100 text-purple-800',
                'yellow': 'bg-yellow-100 text-yellow-800',
                'indigo': 'bg-indigo-100 text-indigo-800',
                'pink': 'bg-pink-100 text-pink-800',
                'gray': 'bg-gray-100 text-gray-800',
                'primary': 'bg-primary-100 text-primary-800',
            }[color]
        }
    }
}
</script>
