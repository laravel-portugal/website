<template>
  <x-dropdown-popper
    class="ml-2"
    :initial-state="open"
  >
    <template #trigger>
      <span class="sr-only">{{ $t('app.options') }}</span>
      <dots-vertical-icon
        class="h-5 w-5 text-gray-400"
        aria-hidden="true"
      />
    </template>

    <template #default>
      <div class="dropdown-label truncate">
        {{ truncateString(tag.name,20) }}
      </div>
      <div class="py-1">
        <!-- Edit -->
        <inertia-link
          :href="route('admin.tags.edit',{tag: tag})"
          class="dropdown-item cursor-pointer"
          role="menuitem"
        >
          <span>{{ $t('app.edit') }}</span>
        </inertia-link>
        <!-- Delete -->
        <inertia-link
          v-if="tag.deleted_at === null"
          :href="route('admin.tags.destroy',{tag: tag})"
          as="button"
          method="delete"
          class="dropdown-item cursor-pointer truncate w-full text-left"
          role="menuitem"
        >
          <span>{{ $t('app.delete') }}</span>
        </inertia-link>
        <!-- Delete Forces -->
        <inertia-link
          v-if="tag.deleted_at !== null"
          :href="route('admin.tags.destroy-forced',{tag: tag})"
          as="button"
          method="delete"
          class="dropdown-item cursor-pointer truncate w-full text-left"
          role="menuitem"
        >
          <span>{{ $t('app.delete-force') }}</span>
        </inertia-link>
        <!-- Restore as a button so it doesnt throw warnings -->
        <inertia-link
          v-if="tag.deleted_at !== null"
          as="button"
          method="put"
          :href="route('admin.tags.restore',{tag: tag})"
          class="dropdown-item cursor-pointer truncate w-full text-left"
          role="menuitem"
        >
          <span>{{ $t('app.restore') }}</span>
        </inertia-link>
      </div>
    </template>
  </x-dropdown-popper>
</template>

<script>
import XDropdownPopper from "@/Components/Menus/DropdownPopper";
import {DotsVerticalIcon} from "@heroicons/vue/outline";
import { truncateString } from "@/Utils/Utils";

export default {
    components: {
        XDropdownPopper,
        DotsVerticalIcon
    },
    props: {
        tag: {
            type: [Object],
            required: true,
        },
        open: {
            type: Boolean,
            default: false,
            required: false
        }
    },
    methods:{
        truncateString: truncateString
    },
}
</script>
