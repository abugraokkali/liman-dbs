<template>
  <cv-tile light>
    <DataTable
      title="Derslerim"
      :columns="[ 'Kodu', 'Adı', 'Akademisyen', 'Durum' ]"
      api="get_lectures_of_student"
      :size="5"
      :sortable="true"
    >
      <template slot="action-buttons">
        <cv-button
          small
          kind="secondary"
          @click="visible=true"
        >
          Ekle
          <div class="btn__icon">
            <Add20 />
          </div>
        </cv-button>
      </template>
    </DataTable>
    <cv-modal
      size="large"
      :visible="visible"
      @after-modal-hidden="visible = false"
      @secondary-click="selectLecture()"
    >
      <template slot="title">Ders Seçimi</template>
      <template slot="content">
        <cv-select
          v-model="selectedLecture"
          class="mb-2"
          label="Dersler"
        >
          <cv-select-option
            v-for="item in choosableLectures"
            :key="item.name"
            :label="item.name"
            :value="item.value"
          ></cv-select-option>
        </cv-select>
      </template>
      <template slot="secondary-button">Talep Oluştur</template>
    </cv-modal>
  </cv-tile>
</template>

<script>
import DataTable from "@/components/DataTable";
import Add20 from "@carbon/icons-vue/es/add/20";
import Download20 from "@carbon/icons-vue/es/download/20";

export default {
  components: {
    DataTable,
    Add20,
    Download20
  },
  data() {
    return {
      visible: false,
      selectedLecture: "",
      choosableLectures: [],
      studentLectures: [],
    };
  },
  mounted() {
    this.getLecturesOfStudent();
  },
  methods: {
    getAllLectures: function () {
      request(
        API("get_lectures"),
        new FormData(),
        (res) => {
          let response = JSON.parse(res).message;
          let arr = [];
          response.forEach((e) => {
            if(!this.studentLectures.some(function(o){return o["code"] === e.code;})) {
              arr.push(e)
            }
          });
          arr.forEach((element) => {
            this.choosableLectures.push({
              name: element["code"] + ": " + element["name"]  + " (" + element["lecturer"] + ")",
              value: element["code"] + "*" + element["lecturer"],
            });
          });
        },
        (res) => {
          let error = JSON.parse(res);
          showSwal(error.message, "error", 3000);
        }
      );
    },
    getLecturesOfStudent: function () {
      request(
        API("get_lectures_of_student"),
        new FormData(),
        (res) => {
          let response = JSON.parse(res).message;
          response.forEach((e) => {
            delete e.status;
          });
          this.studentLectures = response;
          this.getAllLectures();
        },
        () => {
          this.getAllLectures();
        }
      );
    },
    selectLecture: function () {
      let form = new FormData();
      form.append('lecturecode',this.selectedLecture.split("*")[0]);
      request(
        API("select_lecture"),
        form,
        () => {
          this.visible = false;
          showSwal("Ders talebiniz akademisyene iletildi", "info", 2000);
          this.sendNotification();
          setTimeout(() => {
            location.reload();
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
        form.append("userid", this.selectedLecture.split("*")[1]);
        form.append("title", 'Ders Talebi');
        form.append("message",  ' ' + this.selectedLecture.split("*")[0] + ' kodlu dersiniz için onay bekliyor.');
        request(
          API("send_notif_with_username"),
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