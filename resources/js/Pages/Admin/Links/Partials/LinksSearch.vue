<template>
  <div class="mb-5">
    <label
      class="sr-only"
      for="search_products"
    >{{ $t('app.search') }}</label>

    <div class="flex rounded-md shadow-sm">
      <div class="relative flex-grow focus-within:z-10">
        <div class="z-30 absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <search-icon
            class="h-5 w-5 text-gray-400"
            aria-hidden="true"
          />
        </div>
        <x-input-text
          ref="search"
          v-model="searchQuery"
          class="block w-full rounded-none rounded-l-md pl-10"
          :placeholder="$t('placeholders.search-for-links')"
          type="search"
          :disabled="!canSearch"
          :class="{'cursor-not-allowed': !canSearch}"
          layout="naked"
        />
      </div>

      <x-dropdown
        align="right"
        class="relative"
      >
        <template #trigger>
          <button-primary
            variant="secondary"
            class="-ml-px relative inline-flex items-center rounded-r-md rounded-l-none text-gray-700 bg-gray-50"
          >
            <sort-ascending-icon
              aria-hidden="true"
              class="h-5 w-5 text-gray-400"
            />
            <span class="ml-2">{{ currentFilter.label }}</span>
            <chevron-down-icon
              class="h-5 w-5 ml-2.5 text-gray-400"
            />
          </button-primary>
        </template>

        <template #default>
          <div
            v-for="(aFilter) in filters"
            :key="aFilter.key"
            class="py-1"
          >
            <a
              :class="{
                'cursor-not-allowed': !canSearch
              }"
              class="dropdown-item cursor-pointer"
              role="menuitem"
              @click.prevent="applyFilter(aFilter)"
            >
              {{ aFilter.label }}
            </a>
          </div>
        </template>
      </x-dropdown>
    </div>
  </div>
</template>

<script>
import XInputText from "@/Components/Inputs/Text";
import XDropdown from "@/Components/Menus/Dropdown";
import ButtonPrimary from "@/Components/Buttons/ButtonPrimary";
import debounce from "lodash/debounce";
import {firstOf,queryParam, queryParams, queryReset} from "@/Utils/Utils";
import find from 'lodash/find';
import {
    SearchIcon,
    SortAscendingIcon,
    ChevronDownIcon
} from "@heroicons/vue/outline";

export default {
    components: {
        ButtonPrimary,
        XDropdown,
        XInputText,
        SearchIcon,
        SortAscendingIcon,
        ChevronDownIcon
    },
    props: {
        filters: {
            type: [Object],
            required: true,
        },
        searchRoute: {
            type: [URL,String],
            required: true,
        },
    },
    data() {
        return {
            searchQuery: queryParam('q', ''),
            filter: queryParam('filter', ''),
            canSearch: true,
        }
    },
    computed:{
        currentFilter(){
            return find(
                this.filters,
                {
                    key: queryParam('filter', '')
                }
            ) || firstOf(this.filters);
        },
    },
    watch: {
        'searchQuery': {
            immediate: false,
            handler(query) {
                this.search(query);
            }
        }
    },
    methods: {
        applyFilter(filter) {
            this.filter = filter.key;
            this.search(this.searchQuery);
        },
        search: debounce(function(query){
            this.$inertia.get(
                this.searchRoute,
                queryParams({q: query, filter: this.filter}),
                {
                    preserveScroll: true,
                    preserveState: true,
                    only: ['links'],
                    onBefore: visit => {
                        this.canSearch = false;
                    },
                    onFinish: () => {
                        this.canSearch = true;
                    },
                }
            );
        },700),
    }
}
</script>
