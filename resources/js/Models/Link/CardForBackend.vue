<template>
  <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
    <div class="flex-shrink-0 border-b border-gray-100 relative">
      <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent" />
      <img
        class="h-32 w-full object-cover"
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
            :tag="tag"
          />
        </div>
        <a
          href="#"
          class="block mt-2"
        >
          <p class="text-sm font-semibold text-gray-900">
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
          <a :href="link.user_id">
            <span class="sr-only">{{ link.user.name }}</span>
            <img
              v-if="link.user.profile_photo_url"
              class="h-10 w-10 rounded-full"
              :src="link.user.profile_photo_url"
              :alt="link.user.name"
            >
            <span
              v-else
              class="inline-flex items-center justify-center rounded-full h-10 w-10 rounded-full bg-indigo-100"
            >
              <span class="text-sm font-light leading-none text-indigo-800">{{ $page.props.user.name_letters }}</span>
            </span>
          </a>
        </div>
        <div :class="{'ml-3': showAuthor}">
          <p
            v-if="showAuthor"
            class="text-sm font-medium text-gray-900"
          >
            <a
              :href="link.user_id"
              class="hover:underline"
            >
              {{ link.user.name }}
            </a>
          </p>
          <div class="flex space-x-1 text-sm text-gray-500">
            <time :datetime="link.created_at">
              {{ link.updated_at_for_humans }}
            </time>
          </div>
        </div>
      </div>

      <!-- Card footer with Likes, Comments & Other stats should go here -->
      <div
        v-if="showButtons"
        class="mt-2"
      >
        <inertia-link
          v-if="link.status === $page.props.guidelines.links.status.published || link.status === $page.props.guidelines.links.status.rejected"
          :href="route('links.edit',{link: link})"
          class="btn w-full text-center"
        >
          <pencil-icon class="h-4 w-4 mr-1 text-gray-500" />
          <span>{{ $t('app.edit') }}</span>
        </inertia-link>
        <button
          v-else-if="link.status === $page.props.guidelines.links.status.waiting_approval"
          class="btn w-full text-center cursor-not-allowed"
        >
          <shield-check-icon class="h-4 w-4 mr-1 text-gray-500" />
          <span>{{ $t('app.edit') }}</span>
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import Tags from "@/Models/Link/Tags";
import {PencilIcon, ShieldCheckIcon } from '@heroicons/vue/outline';
export default {
    components: {
        Tags,
        PencilIcon,
        ShieldCheckIcon,
    },
    props: {
        link: {
            type: [Object, Array],
            required: true,
        },
        showAuthor: {
            type: [Boolean],
            required: false,
            default: false
        },
        showButtons: {
            type: [Boolean],
            required: false,
            default: true
        }
    },
};
</script>
