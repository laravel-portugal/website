<template>
  <li @contextmenu.prevent="optionsOpen = !optionsOpen">
    <div class="block hover:bg-gray-50">
      <div class="px-4 py-4 flex items-center sm:px-6">
        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
          <div class="truncate">
            <div class="flex text-sm">
              <p class="font-medium text-primary-600 truncate">
                {{ tag.name }}
              </p>
            </div>
            <div class="flex text-sm">
              <p class="flex-shrink-0 font-normal text-xs text-gray-500 truncate">
                {{ tag.description }}
              </p>
            </div>
            <div class="mt-2 flex">
              <!--              <div class="flex items-center text-xs text-gray-500 mr-2">-->
              <!--                <users-icon-->
              <!--                  class="flex-shrink-0 mr-1 h-2 w-2 text-gray-400"-->
              <!--                  aria-hidden="true"-->
              <!--                />-->
              <!--                <div class="flex flex-shrink-1 items-center justify-center space-x-1">-->
              <!--                  <span>{{ $t('app.by') }}</span>-->
              <!--                  <span class="font-bold">{{ link.author.name }}</span>-->
              <!--                </div>-->
              <!--              </div>-->
              <div class="flex items-center text-xs text-gray-500">
                <link-icon
                  class="flex-shrink-0 mr-1 h-2 w-2 text-gray-400"
                  aria-hidden="true"
                />
                <p>
                  {{ $t('app.tags.links_count') }}: {{ tag.links_count }}
                </p>
              </div>
            </div>
          </div>
          <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
            <div class="flex overflow-hidden">
              <!-- Deleted Label -->
              <span
                v-if="tag.deleted_at !== null"
                class="ml-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"
              >
                <trash-icon
                  class="h-3 w-3 mr-1"
                />
                <span>{{ $t('app.deleted') }}</span>
              </span>
            </div>
          </div>
        </div>
        <!-- Right side Area for Options -->
        <div class="ml-5 flex-shrink-0">
          <actions
            :tag="tag"
            :open="optionsOpen"
          />
        </div>
      </div>
    </div>
  </li>
</template>

<script>
import {UsersIcon, LinkIcon,TrashIcon} from "@heroicons/vue/outline";
import Actions from "@/Models/Tag/Actions";

export default {
    components: {
        Actions,
        UsersIcon,
        LinkIcon,
        TrashIcon
    },
    props: {
        tag: {
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
