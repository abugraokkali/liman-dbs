<template>
  <cv-tile
    light
    style="margin: auto; width: 60%; height: 350px;"
  >
    <br>
    <cv-select
      v-model="selectedLecturer"
      class="mb-2"
      label="Akademisyen"
    >
      <cv-select-option
        v-for="item in allLecturers"
        :key="item.name"
        :label="item.name"
        :value="item.value"
      ></cv-select-option>
    </cv-select>
    <cv-text-input
      label="Ders Kodu"
      v-model="lectureCode"
      class="mb-2"
    >
    </cv-text-input>
    <cv-text-input
      label="Ders Adı"
      v-model="lectureName"
    >
    </cv-text-input>
    <cv-button
      class="mt-3"
      style="float: right"
      kind="primary"
      size="field"
      @click="createLecture"
    >
      Oluştur
      <div class="btn__icon">
        <Save20 />
      </div>
    </cv-button>
  </cv-tile>
</template>
<script>
import Save20 from "@carbon/icons-vue/es/save/20";
export default {
  components: {
    Save20,
  },
  data() {
    return {
      allLecturers: [],
      selectedLecturer: "",
      lectureCode: "",
      lectureName: "",
    };
  },
  mounted() {
    this.getallLecturers();
  },
  methods: {
    getallLecturers: function () {
      request(
        API("get_lecturers"),
        new FormData(),
        (res) => {
          let response = JSON.parse(res).message;
          response.forEach((element) => {
            this.allLecturers.push({
              name: element["name"],
              value: element["email"],
            });
          });
          this.filteredGroups = this.allLecturers;
        },
        (res) => {
          let error = JSON.parse(res);
          showSwal(error.message, "error", 3000);
        }
      );
    },
    createLecture: function () {
        let form = new FormData();
        form.append("name", this.lectureName);
        form.append("code", this.lectureCode);
        form.append("lecturer", this.selectedLecturer);
        request(
          API("create_lecture"),
          form,
          () => {
            showSwal("Ders başarıyla eklendi", "success", 2000);
            this.sendNotification();
            setTimeout(() => {
              this.$router.push({
                path: `/lectures`,
              });
            }, 2000);
          },
          (res) => {
            let error = JSON.parse(res);
            showSwal(error.message, "error", 3000);
          }
        );
    },
    sendNotification: function () {
      let form = new FormData();
      form.append("userid", this.selectedLecturer);
      form.append("title", 'Ders Ataması');
      form.append("message", this.lectureCode + ': ' + this.lectureName + ' tarafınıza atanmıştır.');
      form.append("type", "notify");      
      request(
        API("send_notif"),
        form,
        () => {},
        (res) => {
          let error = JSON.parse(res);
          showSwal(error.message, "error", 3000);
        }
      );
    },
  },
};
</script>