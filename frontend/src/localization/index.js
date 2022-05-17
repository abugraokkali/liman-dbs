import Vue from "vue";
import VueI18n from "vue-i18n";

import tr from "./tr.json";
import en from "./en.json";

const defaultLocale = $("#app").attr("locale");
const languages = {
  tr: tr,
  en: en,
};
const messages = Object.assign(languages);

Vue.use(VueI18n);

let i18n = new VueI18n({
  locale: defaultLocale,
  fallbackLocale: "en",
  messages,
  preserveDirectiveContent: true,
  silentTranslationWarn: true,
});

export default i18n;