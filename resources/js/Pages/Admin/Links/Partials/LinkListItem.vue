<template>
  <li @contextmenu.prevent="optionsOpen = !optionsOpen">
    <div class="block hover:bg-gray-50">
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
                  <span>{{ $t('app.by') }}</span>
                  <span class="font-bold">{{ link.author.name }}</span>
                </div>
              </div>
              <div class="flex items-center text-xs text-gray-500">
                <clock-icon
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
              <status-badge :status="link.status" />
            </div>
          </div>
        </div>
        <div class="ml-5 flex-shrink-0">
          <actions
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
import StatusBadge from "@/Models/Link/StatusBadge";
import Actions from "@/Models/Link/Actions";

export default {
    components: {
        Actions,
        StatusBadge,
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
