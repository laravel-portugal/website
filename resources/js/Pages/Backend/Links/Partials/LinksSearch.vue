<template>
  <div class="mb-5">
    <label
      class="sr-only"
      for="search_products"
    >Search</label>

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
          :placeholder="'Search for links here'"
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
            <span class="ml-2">{{ currentSmartFilter.label }}</span>
            <chevron-down-icon
              class="h-5 w-5 ml-2.5 text-gray-400"
            />
          </button-primary>
        </template>

        <template #default>
          <div
            v-for="(sorting) in smartFilterOptions"
            :key="sorting.key"
            class="py-1"
          >
            <a
              :class="{
                'cursor-not-allowed': !canSearch
              }"
              class="dropdown-item cursor-pointer"
              role="menuitem"
              @click.prevent="applySmartFilter(sorting)"
            >
              {{ sorting.label }}
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
import {firstOf,queryParam} from "@/Utils/Utils";
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
    data() {
        return {
            searchQuery: queryParam('q', ''),
            smartFilter: queryParam('smart_filter', 'default'),
            currentSmartFilter: [],
            canSearch: true,
        }
    },
    computed:{
        links(){
            return this.$page.props.links.data
        },
        smartFilterOptions() {
            return [
                {key: 'default', label: 'Default'},
                {key: 'status-published', label: 'Published'},
                {key: 'status-rejected', label: 'Rejected'},
                {key: 'status-waiting-approval', label: 'Waiting Approval'},
                {key: 'updated-asc', label: 'Recently Updated'},
                {key: 'created-desc', label: 'Recently Created'},
            ];
        }
    },
    watch: {
        'searchQuery': {
            immediate: false,
            handler(query) {
                console.log('Trigger',query)
                this.search(query);
            }
        }
    },
    mounted() {
        this.currentSmartFilter = find(this.smartFilterOptions, {'key': this.smartFilter});
    },
    methods: {
        performReset() {
            this.applyDefaultSorting();
            this.searchQuery = '';
            this.smartFilter = '';
            this.search('');
        },
        applySmartFilter(filter) {
            this.smartFilter = filter.key;
            this.currentSmartFilter = filter;
            this.search(this.searchQuery);
        },
        search: debounce(function(searchQuery){
            let params = {};

            if (searchQuery && searchQuery?.length >= 2) {
                params.q = searchQuery || '';
            }
            if (this.smartFilter !== '') {
                params.smart_filter = this.smartFilter;
            }

            this.$inertia.get(
                this.route('admin.links.index'),
                params,
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
        applySearchQuery() {
            this.searchQuery = '';
            let query = queryParam('q', '');
            if (query.length >= 2) {
                this.searchQuery = query;
                this.search();
            }
        },
        applyDefaultSorting() {
            this.currentSmartFilter = firstOf(this.smartFilterOptions);
            let smartFilter = queryParam('smart_filter', '');
            if (smartFilter.length >= 2) {
                this.currentSmartFilter = find(this.smartFilterOptions, {'key': smartFilter});
                if (this.currentSmartFilter) {
                    this.smartFilter = this.currentSmartFilter.key;
                }
            }
        }
    }
}
</script>
