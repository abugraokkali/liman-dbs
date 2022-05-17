<template>
  <cv-tile light>
    <div class="container-fluid">
      <cv-button
        kind="secondary"
        size="field"
        @click="redirect"
        class="mb-4"
      >
        Kullanıcı Ayarları
        <div class="btn__icon">
          <User20 />
        </div>
      </cv-button>
      <div class="row">
          <div class="col">
            <DataTable
              title="Öğrenciler"
              :columns="[ 'Kullanıcı Adı', 'E-mail' ]"
              api="get_students"
              :size="5"
              :sortable="true"
            >
            </DataTable>
          </div>
          <div class="col">
          <DataTable
              title="Akademisyenler"
              :columns="[ 'Kullanıcı Adı', 'E-mail' ]"
              api="get_lecturers"
              :size="5"
              :sortable="true"
            >
            </DataTable>
          </div>
      </div>
    </div>
  </cv-tile>

</template>

<script>
import User20 from "@carbon/icons-vue/es/user/20";
import Add20 from "@carbon/icons-vue/es/add/20";
import DataTable from "@/components/DataTable";

export default {
  components: {
    User20,
    Add20,
    DataTable
  },
  data() {
    return {
    };
  },
  methods: {
    redirect() {
      window.location = '/ayarlar#users'
    },
  },
};
</script>