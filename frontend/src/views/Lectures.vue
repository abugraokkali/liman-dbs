<template>
    <cv-tile light>
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <cv-tile light>
              <DataTable
                title="Dersler"
                :columns="[ 'Kodu', 'Adı', 'Akademisyen' ]"
                api="get_lectures"
                :size="5"
                :sortable="true"
              >
                <template slot="action-buttons">
                  <cv-button
                    small
                    kind="secondary"
                    @click="$router.push({path: `/addlecture`})"
                  >
                    Oluştur
                    <div class="btn__icon">
                      <Add20 />
                    </div>
                  </cv-button>
                </template>
              </DataTable>
            </cv-tile>
          </div>
        </div>
      </div>
    </cv-tile>
</template>

<script>
import Add20 from "@carbon/icons-vue/es/add/20";
import DataTable from "@/components/DataTable";

export default {
  components: {
    DataTable,
    Add20
  },
  data() {
    return {
    };
  },
  methods: {
  },
};
</script>