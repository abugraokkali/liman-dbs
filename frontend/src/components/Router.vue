<template>
  <div :class="{ 'mn-20': !fullscreen }">
    <cv-header>
      <cv-header-name
        to="/"
        prefix="HAVELSAN"
      > OBS <i style="margin-left: 7px !important" class="fa-solid fa-graduation-cap"></i></cv-header-name>
      <cv-header-nav>
        <template v-for="item in items">
          <template v-if="item.children">
            <cv-header-menu
              :title="item.topName"
              v-bind:key="item.name"
              v-if="item.shownName && item.topName && item.show !== false"
              exact
            >
              <cv-header-menu-item
                :to="item.path"
                v-bind:key="item.name"
                v-if="item.shownName && item.show !== false"
                exact
              >
                {{ $t(item.shownName) }}
              </cv-header-menu-item>
              <template v-for="child in item.children">
                <cv-header-menu-item
                  :to="item.path + '/' + child.path"
                  v-bind:key="child.name"
                  v-if="child.shownName && child.show !== false"
                  exact
                >
                  {{ $t(child.shownName) }}
                </cv-header-menu-item>
              </template>
            </cv-header-menu>
          </template>
          <template v-else>
            <cv-header-menu-item
              :to="item.path"
              v-bind:key="item.name"
              v-if="item.shownName && item.show !== false"
              exact
            >
              {{ $t(item.shownName) }}
            </cv-header-menu-item>
          </template>
        </template>
      </cv-header-nav>
      <template v-slot:header-global>
      <cv-header-global-action
          aria-controls="notifications-panel"
          label="Kullanıcı Tipi"
          style="width: 7rem;"
        >
          <User20 /> {{ userType }}
        </cv-header-global-action>
        <cv-header-global-action
          aria-label="Full Screen"
          aria-controls="notifications-panel"
          @click="toggleFullscreen"
          :label="(!fullscreen)  ? 'Büyült' : 'Küçült'"
          tipPosition="bottom"
          tipAlignment="center"
        >
          <Maximize20 v-if="!fullscreen" />
          <Minimize20 v-else />
        </cv-header-global-action>
        <cv-header-global-action
          aria-controls="notifications-panel"
          @click="support"
          label="Yardım"
          tipPosition="bottom"
          tipAlignment="start"
        >
          <Help20 />
        </cv-header-global-action>
        <cv-header-global-action
          aria-controls="user-panel"
          @click="settings"
          label="Eklenti Ayarları"
          tipPosition="bottom"
          tipAlignment="end"
        >
          <SettingsAdjust20 />
        </cv-header-global-action>
      </template>
    </cv-header>
  </div>
</template>

<script>
import Help20 from "@carbon/icons-vue/es/help/20";
import User20 from "@carbon/icons-vue/es/user/20";
import SettingsAdjust20 from "@carbon/icons-vue/es/settings--adjust/20";
import Maximize20 from "@carbon/icons-vue/es/maximize/20";
import Minimize20 from "@carbon/icons-vue/es/minimize/20";

export default {
  components: {
    Help20,
    SettingsAdjust20,
    Maximize20,
    Minimize20,
    User20,
  },
  created() {
    this.$router.options.routes.forEach((route) => {
      this.items.push({
        name: route.name,
        path: route.path,
        shownName: route.shownName,
        topName: route.topName,
        show: route.show,
        children: route.children,
      });
    });
    this.getUserType();
  },
  computed: {
    fullscreen() {
      return this.$store.getters["getFullscreen"];
    },
  },
  data() {
    return {
      items: [],
      buttons: returnButtons(),
      userType: "",
    };
  },
  methods: {
    toggleFullscreen() {
      this.$emit("fullscreen");
    },
    support() {
      window.location.href =
        "mailto:" + encodeURIComponent(this.buttons.support);
    },
    settings() {
      window.location.href = this.buttons.settings;
    },
    getUserType() {
      if(can('adminPermission')) this.userType = 'Yönetici';
      if(can('lecturerPermission')) this.userType = 'Akademisyen';
      if(can('studentPermission')) this.userType = 'Öğrenci';
    },
  },
};
</script>

<style scoped>
* {
  transition: 0.3s all;
}

.bx--header {
  position: relative !important;
  z-index: 25 !important;
}

.mn-20 {
  margin: -20px -20px 20px -20px;
}
</style>
