<template>
  <div class="relative">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="relative px-4 py-16 sm:px-6 sm:py-24 lg:pt-44 lg:pb-60 lg:px-8">
        <h1 class="text-center text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl font-roboto">
          <span
            class="block text-white"
            v-html="$t('app.hero-title')"
          />
          <span
            class="block text-gray-100"
            v-html="$t('app.hero-title-part')"
          />
        </h1>
        <p class="mt-6 max-w-lg mx-auto text-center text-xl text-white sm:max-w-3xl">
          {{ $t('app.hero-subtitle') }}
        </p>
        <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center">
          <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-5">
            <a
              :href="$page.props.meta.social.discord"
              target="_blank"
              rel="nofollow"
              class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-base bg-white hover:bg-indigo-50 sm:px-8"
            >
              {{ $t('app.hero-button-one') }}
            </a>
            <a
              href="#links"
              class="flex items-center justify-center px-4 py-3 border border-white text-base font-medium rounded-md shadow-sm text-white bg-transparent bg-opacity-60 hover:bg-opacity-70 sm:px-8"
            >
              {{ $t('app.hero-button-two') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
