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
      <template slot="title">{{selectedLecture}} Alan Öğrenciler</template>
      <template slot="content">
        <cv-tile light>
          <DataTable
            :key="selectedLecture"
            title=""
            :columns="[ 'E-mail' ]"
            api="get_students_of_lecture"
            :size="5"
            :id="selectedLecture"
            :sortable="true"
          >
          </DataTable>
        </cv-tile>
      </template>
    </cv-modal>
  </div>
</template>

<script>
import DataTable from "@/components/DataTable";

export default {
  components: {
    DataTable
  },
  data() {
    return {
      visible: false,
      selectedLecture: ""
    };
  },
  methods: {
    onClick(row) {
      this.selectedLecture = row.code;
      this.visible = true;
    },
  },
};
</script>