<template>
  <li @contextmenu.prevent="optionsOpen = !optionsOpen">
    <div
      class="block hover:bg-gray-50"
    >
      <div class="px-4 py-4 flex items-center sm:px-6">
        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
          <div class="truncate">
            <div class="flex text-sm">
              <p class="font-medium text-primary-600 truncate">
                {{ link.title }}
              </p>
            </div>
            <div class="flex text-sm">
              <p class="flex-shrink-0 font-normal text-xs text-gray-500 truncate">
                {{ link.url }}
              </p>
            </div>
            <div class="mt-2 flex">
              <div class="flex items-center text-xs text-gray-500 mr-2">
                <users-icon
                  class="flex-shrink-0 mr-1 h-2 w-2 text-gray-400"
                  aria-hidden="true"
                />
                <div class="flex flex-shrink-1 items-center justify-center space-x-1">
                  <span>By</span>
                  <span class="font-bold">{{ link.author.name }}</span>
                </div>
              </div>
              <div class="flex items-center text-xs text-gray-500">
                <ClockIcon
                  class="flex-shrink-0 mr-1 h-2 w-2 text-gray-400"
                  aria-hidden="true"
                />
                <p>
                  <time :datetime="link.updated_at">{{ link.updated_at_for_humans }}</time>
                </p>
              </div>
            </div>
          </div>
          <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
            <div class="flex overflow-hidden">
              <link-status-badge :status="link.status" />
            </div>
          </div>
        </div>
        <div class="ml-5 flex-shrink-0">
          <link-list-item-actions
            :link="link"
            :open="optionsOpen"
          />
        </div>
      </div>
    </div>
  </li>
</template>

<script>
import {UsersIcon, ClockIcon} from "@heroicons/vue/outline";
import LinkStatusBadge from "@/Pages/Links/Partials/LinkStatusBadge";
import LinkListItemActions from "@/Pages/Backend/Links/Partials/LinkListItemActions";

export default {
    components: {
        LinkListItemActions,
        LinkStatusBadge,
        UsersIcon,
        ClockIcon
    },
    props: {
        link: {
            type: [Object],
            required: true,
        },
    },
    data(){
        return {
            optionsOpen: false
        }
    },
}
</script>
