<template>
  <div>
    <cv-tile light>
      <DataTable
        title="Derslerim"
        :columns="[ 'Kodu', 'Adı' ]"
        api="get_lectures_of_lecturer"
        :size="5"
        :sortable="true"
        clickableName
        :onClick="onClick"
      >
      </DataTable>
      
    </cv-tile>
    <cv-modal
      size="large"
      :visible="visible"
      @after-modal-hidden="visible = false"
    >
      <template slot="title">{{selectedLecture}}</template>
      <template slot="content">
        <cv-tile light>
          <cv-tabs aria-label="navigation tab label">
            <cv-tab label="Kayıtlı Öğrenciler">
              <DataTable
                :key="selectedLecture"
                :showTitle='false'
                :title="selectedLecture + 'KayıtlıÖğrenciler'"
                :columns="[ 'E-mail', 'Durum']"
                api="get_students_of_lecture_approved"
                :size="5"
                :id="selectedLecture"
                :sortable="true"
              >
              </DataTable>
            </cv-tab>
            <cv-tab label="Onay Bekleyenler" >
              <DataTable
                :key="selectedLecture"
                :showTitle='false'
                :title="selectedLecture + 'OnayBekleyenler'"
                :columns="[ 'E-mail', 'Durum', 'Operasyon']"
                api="get_students_of_lecture_waiting"
                :size="5"
                :id="selectedLecture"
                :sortable="true"
                type="lecturer"
                :lectureCode="selectedLecture"
              >
              </DataTable>
            </cv-tab>
            <cv-tab label="Duyuru" >
              <cv-text-input
                class="mt-3"
                label="Başlık"
                v-model="title">
              </cv-text-input>
              <cv-text-area
                class="mt-2"
                label="Mesaj"
                v-model="message">
              </cv-text-area>
              <cv-button
                class="mt-3"
                kind="primary"
                size="field"
                @click="sendAnnouncement"
              >
                Gönder
                <div class="btn__icon">
                  <Send20 />
                </div>
              </cv-button>
            </cv-tab>
          </cv-tabs>
        </cv-tile>
      </template>
    </cv-modal>
  </div>
</template>

<script>
import DataTable from "@/components/DataTable";
import Send20 from "@carbon/icons-vue/es/send/20";

export default {
  components: {
    DataTable,
    Send20
  },
  data() {
    return {
      visible: false,
      selectedLecture: "",
      title: "",
      message: "",
    };
  },
  methods: {
    onClick(row) {
      this.selectedLecture = row.code;
      this.visible = true;
    },
    sendAnnouncement() {
      let form = new FormData();
      form.append("lecturecode", this.selectedLecture);
      form.append("title", this.title);
      form.append("message", this.message);
      form.append("type", "liman_update");      
      request(
        API("send_announcement"),
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