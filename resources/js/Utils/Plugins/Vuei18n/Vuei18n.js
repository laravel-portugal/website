import languageBundle from '../../../../lang/index';
import { createI18n } from 'vue-i18n';

// Define the locale based on document
const locale = 'pt';
if (typeof window !== 'undefined' && typeof document !== 'undefined') {
    const locale = document.documentElement.lang.substr(0, 2);
}

export const i18n = createI18n({
    locale: locale,
    messages: languageBundle,
});
