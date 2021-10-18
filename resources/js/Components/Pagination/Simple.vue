<template>
  <div class="px-4 py-3 flex items-center justify-between sm:px-6">
    <div class="flex-1 flex justify-between sm:hidden">
      <a
        :class="{'cursor-not-allowed': links.previous === null}"
        :disabled="links.previous !== null"
        class="pagination-button"
        @click.prevent="navigate(links.previous)"
        v-html="$t('app.pagination.previous')"
      />
      <a
        :class="{'cursor-not-allowed': links.next === null}"
        :disabled="links.next !== null"
        :href="links.next"
        class="pagination-button ml-3"
        @click.prevent="navigate(links.next)"
        v-html="$t('app.pagination.next')"
      />
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p
          v-if="showNumberOfItems"
          class="text-sm leading-5 text-gray-700 dark:text-gray-400"
        >
          <span
            v-html="$t('app.pagination.showing-results',{from: meta.from,to: meta.to, total: meta.total})"
          />
        </p>
      </div>
      <div>
        <nav class="relative z-0 inline-flex shadow-sm">
          <a
            :class="{'cursor-not-allowed text-gray-200 hover:text-gray-200': links.previous === null}"
            :disabled="links.previous !== null"
            aria-label="Previous"
            class="pagination-button-short rounded-l-md"
            @click.prevent="navigate(links.previous)"
          >
            <chevron-left-icon class="h-5 w-5" />
          </a>

          <template v-if="showPages">
            <a
              v-for="(link, key) in links.pages"
              :key="key"
              :class="{'bg-primary-500 text-white': link.active}"
              class="pagination-button-page"
              @click.prevent="navigate(links.url)"
            >
              {{ link.label }}
            </a>
          </template>

          <a
            :class="{'cursor-not-allowed text-gray-200 hover:text-gray-200': links.next === null}"
            :disabled="links.next !== null"
            aria-label="Next"
            class="pagination-button-short -ml-px rounded-r-md"
            @click.prevent="navigate(links.next)"
          >
            <chevron-right-icon class="h-5 w-5" />
          </a>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import {
    ChevronRightIcon,
    ChevronLeftIcon,
} from '@heroicons/vue/outline';

export default {
    name: 'XPaginationSimple',
    components: {
        ChevronRightIcon,
        ChevronLeftIcon
    },
    props: {
        links: {
            type: [Object, Array],
            default: () => []
        },
        meta: {
            type: [Object, Array],
            default: () => []
        },
        loading: {
            type: Boolean,
            required: false,
            default: false
        },
        showPages: {
            type: Boolean,
            required: false,
            default: false
        },
        showNumberOfItems: {
            type: Boolean,
            required: false,
            default: true,
        },
    },
    methods: {
        navigate(page) {
            if (page !== null) {
                this.$inertia.get(page, {}, {
                    preserveScroll: true,
                })
            }
        }
    }
}
</script>
