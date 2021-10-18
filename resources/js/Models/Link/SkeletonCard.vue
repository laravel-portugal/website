<template>
  <inertia-link
    :href="route('links.create')"
    class="flex flex-col rounded-lg shadow-lg overflow-hidden blur-xs select-none"
  >
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-100" />
    <div class="flex-shrink-0 border-b border-gray-100">
      <img
        class="h-32 w-full object-cover filter grayscale"
        :src="link.cover_image_url"
        :alt="link.title"
      >
    </div>
    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
      <div class="flex-1">
        <div
          v-if="link.tags.length > 0"
          class="text-sm font-medium"
        >
          <tags
            v-for="tag in link.tags"
            :key="tag.id"
            class="hover:no-underline"
            :tag="tag"
          />
        </div>
        <div
          class="block mt-2"
        >
          <p class="text-sm font-semibold text-gray-900">
            {{ link.title }}
          </p>
          <p class="mt-3 text-xs text-gray-500">
            {{ link.description }}
          </p>
        </div>
      </div>
      <div class="mt-2 flex items-center">
        <div>
          <div class="flex space-x-1 text-sm text-gray-500">
            <time :datetime="link.created_at">
              {{ link.updated_at_for_humans }}
            </time>
          </div>
        </div>
      </div>
      <div class="mt-2">
        <div class="btn w-full block text-center">
          {{ $t('app.link_status.waiting_approval') }}
        </div>
      </div>
    </div>
  </inertia-link>
</template>
<script>
import Tags from "@/Models/Link/Tags";

export default {
    components: {
        Tags,
    },
    props: {
        link: {
            type: [Object, Array],
            required: true,
        },
    },
};
</script>
