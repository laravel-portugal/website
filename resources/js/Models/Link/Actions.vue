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
        {{ truncateString(link.title,20) }}
      </div>
      <div class="py-1">
        <a
          :href="link.url"
          target="_blank"
          class="dropdown-item cursor-pointer"
          role="menuitem"
        >
          <span>{{ $t('app.links-visit') }}</span>
        </a>
        <!-- Edit -->
        <inertia-link
          :href="route('admin.links.edit',{link: link})"
          class="dropdown-item cursor-pointer"
          role="menuitem"
        >
          <span>{{ $t('app.edit') }}</span>
        </inertia-link>
        <!-- Actual Actions to move status -->
        <inertia-link
          :href="route('admin.links.status',{ link: link, status: $page.props.guidelines.links.status.published })"
          class="dropdown-item cursor-pointer"
          role="menuitem"
          preserve-scroll
        >
          <span>{{ $t('app.links-mark-as-published') }}</span>
        </inertia-link>
        <inertia-link
          :href="route('admin.links.status',{ link: link, status: $page.props.guidelines.links.status.waiting_approval })"
          class="dropdown-item cursor-pointer"
          role="menuitem"
          preserve-scroll
        >
          <span>{{ $t('app.links-mark-as-waiting-approval') }}</span>
        </inertia-link>
        <inertia-link
          :href="route('admin.links.status',{ link: link, status: $page.props.guidelines.links.status.rejected })"
          class="dropdown-item cursor-pointer"
          role="menuitem"
          preserve-scroll
        >
          <span>{{ $t('app.links-mark-as-rejected') }}</span>
        </inertia-link>
        <!-- Delete -->
        <inertia-link
          v-if="link.deleted_at === null"
          :href="route('admin.links.destroy',{link: link})"
          as="button"
          method="delete"
          class="dropdown-item cursor-pointer truncate w-full text-left"
          role="menuitem"
        >
          <span>{{ $t('app.delete') }}</span>
        </inertia-link>
        <!-- Restore as a button so it doesnt throw warnings -->
        <inertia-link
          v-if="link.deleted_at !== null"
          as="button"
          method="put"
          :href="route('admin.links.restore',{link: link})"
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
        link: {
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
