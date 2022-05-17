// Import Statements
import Vue from "vue";
// eslint-disable-next-line
// import _ from "lodash";
import App from "./Main.vue";
import router from "./routes";
import store from "./store/index.js";
import i18n from "./localization"
import VuePageTransition from "vue-page-transition";
import CarbonComponentsVue from '@limanmys/carbon-vue';
import ChartsVue from "@carbon/charts-vue";
import { Settings } from "luxon";

// CSS Imports
import './styles/carbon-build.css';
import './styles/carbon-charts.css';
import './styles/custom-styles.css';

// Global Components
Vue.use(CarbonComponentsVue);
Vue.use(ChartsVue);
Vue.use(VuePageTransition);

Vue.prototype.$can = (perm) => {
  return can(perm);
};

Vue.prototype.$userStatus = () => {
  return userStatus();
}
// Vue
new Vue({
  i18n,
  beforeMount: function () {
    Settings.defaultLocale = i18n.locale;
  },
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
