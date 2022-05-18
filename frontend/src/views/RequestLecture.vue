<template>
  <cv-tile
    light
    style="margin: auto; width: 60%; height: 175px;"
  >
    <cv-text-input
      class="mt-3"
      label="Açılmasını İstediğiniz Ders Kodu"
      v-model="message">
    </cv-text-input>
    <cv-button
      class="mt-3"
      kind="primary"
      size="field"
      @click="sendNotification"
    >
      Gönder
      <div class="btn__icon">
          <Send20 />
      </div>
    </cv-button>
  </cv-tile>
</template>
<script>
import Send20 from "@carbon/icons-vue/es/send/20";
export default {
  components: {
    Send20,
  },
  data() {
    return {
      message: "",
    };
  },
  mounted() {
  },
  methods: {
    sendNotification: function () {
        let form = new FormData();
        form.append("userid", "administrator@liman.dev");
        form.append("title", 'Ders Talebi');
        form.append("message",  ' ' + this.message + ' kodlu dersin açılmasını talep ediyor.');
        if(this.message) {
          request(
            API("send_notif_with_username"),
            form,
            () => {
              showSwal("Ders talebiniz sistem yöneticinize iletildi.", "success", 2000);
            },
            (res) => {
              let error = JSON.parse(res);
              showSwal(error.message, "error", 3000);
            }
          );
        }
        else {
          showSwal("Ders kodu alanı boş bırakılamaz!", "error", 2000);
        }
       
    },
  },
};
</script>