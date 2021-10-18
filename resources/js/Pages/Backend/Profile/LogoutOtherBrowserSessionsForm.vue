<template>
  <x-card
    :subtitle="$t('users.sessions-subtitle')"
    :title="$t('users.sessions-title')"
    body-classes="bg-gray-50 dark:bg-gray-800"
  >
    <div class="px-4 py-5 sm:p-6">
      <p class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
        {{ $t('users.sessions-description') }}
      </p>

      <div
        v-if="sessions.length > 0"
        class="mt-5 space-y-6"
      >
        <div
          v-for="session in sessions"
          :key="session.id"
          class="flex items-center"
        >
          <div>
            <desktop-computer-icon
              v-if="session.agent.is_desktop"
              class="w-8 h-8 text-gray-500"
            />
            <device-mobile-icon
              v-else
              class="w-8 h-8 text-gray-500"
            />
          </div>

          <div class="ml-3">
            <div class="text-sm text-gray-600 dark:text-white">
              {{ session.agent.platform }} - {{ session.agent.browser }}
            </div>
            <div>
              <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ session.ip_address }},
                <span
                  v-if="session.is_current_device"
                  class="text-green-500 font-semibold flex inline-flex items-center justify-center space-x-2"
                >
                  <x-status-indicator
                    :pulse="false"
                    color="green"
                  />
                  <span>{{ $t('users.sessions-this-device') }}</span>
                </span>
                <span v-else>{{
                  $t('users.sessions-last-active', {time: session.last_active})
                }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <template #footer>
      <div>
        <x-modal-confirm-password
          :force="true"
          @confirmed="logoutOtherBrowserSessions"
        >
          <button-loading
            :loading="confirmingLogout"
            type="button"
            variant="danger"
          >
            {{ $t('users.sessions-logout-other') }}
          </button-loading>
        </x-modal-confirm-password>
      </div>
    </template>
  </x-card>
</template>

<script>
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import XStatusIndicator from "@/Components/Animations/StatusIndicator";
import {useForm} from "@inertiajs/inertia-vue3";
import XModalConfirmPassword from "@/Components/Modals/ConfirmPassword";
import XCard from "@/Components/Cards/Card";
import {
    DesktopComputerIcon,
    DeviceMobileIcon,
} from '@heroicons/vue/outline';

export default {

    components: {
        XCard,
        XModalConfirmPassword,
        XStatusIndicator,
        DesktopComputerIcon,
        DeviceMobileIcon,
        ButtonLoading,
    },
    props: {
        sessions: {
            type: [Object, Array],
            required: false,
            default: () => {
                return [];
            }
        },
    },

    data() {
        return {
            confirmingLogout: false,
            form: useForm({
                '_method': 'DELETE',
                password: '',
            })
        }
    },
    methods: {
        logoutOtherBrowserSessions(secret) {
            this.form.password = secret;
            this.form.post('/user/other-browser-sessions', {
                preserveScroll: true,
                errorBag: 'logoutOtherBrowserSessions',
                onFinish: () => this.confirmingLogout = false
            });
        },
    },
}
</script>
