<template>
  <div
    id="carbon"
    :class="{ full_screen: fullscreen }"
  >
    <router @fullscreen="toggleFullscreen" />
    <div :class="{ 'ml-5mr-15': !fullscreen, padding15px: fullscreen }">
      <vue-page-transition name="fade-in-up">
        <router-view />
      </vue-page-transition>
    </div>
  </div>
</template>

<script>
import Router from "@/components/Router";
export default {
  components: {
    Router,
  },
  computed: {
    fullscreen() {
      return this.$store.getters["getFullscreen"];
    },
  },
  beforeMount() {
    if (localStorage.getItem("NETWORK-fullscreen") == "true") {
      $("body").toggleClass("overflow_hidden");
      this.$store.commit("setFullscreen");
    }
    $("#ext_menu").parent().parent().fadeOut();
    $(".customAlert").fadeOut();
  },
  methods: {
    toggleFullscreen() {
      localStorage.setItem("NETWORK-fullscreen", !this.fullscreen);
      this.$store.commit("setFullscreen");
      $("body").toggleClass("overflow_hidden");
    },
  },
};
</script>

<style>
.ml-5mr-15 {
  margin-left: -5px;
  margin-right: -15px;
}
.padding15px {
  padding: 20px;
}

body > div.wrapper > div.content-wrapper > section > div > div > div > div {
  margin: 0 -15px;
  box-shadow: none;
  background-color: transparent;
}
</style>