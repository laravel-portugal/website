import languageBundle from '../../../../lang/index';
import { createI18n } from 'vue-i18n';
import { notSSR } from "@/Utils/Utils";

// Define the locale based on document
const locale = 'pt';
const fallbackLocale = ['en','pt'];
if (notSSR()) {
    const locale = document.documentElement.lang.substr(0, 2);
}

export const i18n = createI18n({
    locale: locale,
    fallbackLocale: fallbackLocale,
    messages: languageBundle,
    silentTranslationWarn: true,
    silentFallbackWarn: true
});
