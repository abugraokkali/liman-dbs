<template>
  <cv-tile light>
    <DataTable
      title="Derslerim"
      :columns="[ 'Kodu', 'Adı', 'Akademisyen' ]"
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
      @primary-click="selectLecture()"
    >
      <template slot="title">Ders Seçimi</template>
      <template slot="content">
        <cv-select
          v-model="selectedLecture"
          class="mb-2"
          label="Dersler"
        >
          <cv-select-option
            v-for="item in allLectures"
            :key="item.name"
            :label="item.name"
            :value="item.value"
          ></cv-select-option>
        </cv-select>
      </template>
      <template slot="primary-button">Talep Oluştur</template>
    </cv-modal>
  </cv-tile>
</template>

<script>
import DataTable from "@/components/DataTable";
import Add20 from "@carbon/icons-vue/es/add/20";

export default {
  components: {
    DataTable,
    Add20
  },
  data() {
    return {
      visible: false,
      selectedLecture: "",
      allLectures: [],
    };
  },
  mounted() {
    this.getAllLectures();
  },
  methods: {
    getAllLectures: function () {
      request(
        API("get_lectures"),
        new FormData(),
        (res) => {
          let response = JSON.parse(res).message;
          response.forEach((element) => {
            this.allLectures.push({
              name: element["code"] + ": " + element["name"],
              value: element["code"],
            });
          });
        },
        (res) => {
          let error = JSON.parse(res);
          showSwal(error.message, "error", 3000);
        }
      );
    },
    selectLecture: function () {
      let form = new FormData();
      form.append('code',this.selectedLecture);
      request(
        API("select_lecture"),
        form,
        () => {
          this.visible = false;
          showSwal("Ders talebiniz akademisyene iletildi", "info", 2000);
        },
        (res) => {
          let error = JSON.parse(res);
          showSwal(error.message, "error", 3000);
        }
      );
    },
  },
};
</script>