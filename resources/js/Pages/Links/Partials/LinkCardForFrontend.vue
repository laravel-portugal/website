<template>
  <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
    <div class="flex-shrink-0 border-b border-gray-100 relative">
      <a
        :href="route('links.public.redirect',{link: link})"
        target="_blank"
      >
        <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent" />
        <img
          class="h-32 w-full object-cover"
          :src="link.cover_image_url"
          :alt="link.title"
        >
      </a>
    </div>
    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
      <div class="flex-1">
        <div
          v-if="link.tags.length > 0"
          class="text-sm font-medium"
        >
          <link-tag
            v-for="tag in link.tags"
            :key="tag.id"
            :tag="tag"
          />
        </div>
        <a
          target="_blank"
          :href="route('links.public.redirect',{link: link})"
          class="block mt-2"
        >
          <p class="text-sm font-semibold text-gray-900 hover:underline">
            {{ link.title }}
          </p>
          <p class="mt-3 text-xs text-gray-500">
            {{ link.description }}
          </p>
        </a>
      </div>
      <div class="mt-2 flex items-center">
        <div
          v-if="showAuthor"
          class="flex-shrink-0"
        >
          <inertia-link :href="route('links.public',{author: link.author.id})">
            <span class="sr-only">{{ link.author.name }}</span>
            <img
              v-if="link.author.profile_photo_url"
              class="h-10 w-10 rounded-full"
              :src="link.author.profile_photo_url"
              :alt="link.author.name"
            >
            <span
              v-else
              class="inline-flex items-center justify-center rounded-full h-10 w-10 rounded-full bg-indigo-100"
            >
              <span class="text-sm font-light leading-none text-indigo-800">{{ link.author.name_letters }}</span>
            </span>
          </inertia-link>
        </div>
        <div :class="{'ml-3': showAuthor}">
          <p
            v-if="showAuthor"
            class="text-sm font-medium text-gray-900"
          >
            <inertia-link
              :href="route('links.public',{author: link.author.id})"
              class="hover:underline"
            >
              {{ link.author.name }}
            </inertia-link>
          </p>
          <div class="flex space-x-1 text-sm text-gray-500">
            <time :datetime="link.created_at">
              {{ link.updated_at_for_humans }}
            </time>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import LinkTag from "@/Pages/Links/Partials/LinkTag";
export default {
    components: {
        LinkTag,
    },
    props: {
        link: {
            type: [Object, Array],
            required: true,
        },
        showAuthor: {
            type: [Boolean],
            required: false,
            default: true
        },
    },
};
</script>
