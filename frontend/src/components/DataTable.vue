<template>
  <div>
    <h5 v-if="showTitle">
      {{title}} ({{ count }})
    </h5>
    <div v-if="loading">
      <cv-data-table-skeleton
        :columns="columns"
        :rows="pageSize"
      ></cv-data-table-skeleton>
    </div>
    <div v-else>
      <cv-data-table
        class="mt-2"
        :columns="columns"
        @sort="onSort"
        :pagination="showPagination? pagination : null"
        @pagination="actionOnPagination"
        :sortable="sortable"
        :paginatorSettings="{
          pageSizesLabel: 'Items per page:',
          pageNumberLabel: 'Sayfa',
          forwardsText: 'Sonraki sayfa',
          backwardsText: 'Önceki sayfa',
        }"
      >
        <template
          v-if="searchable"
          slot="actions"
        >
          <cv-search v-model="search"> </cv-search>
          <export-excel
            class   = "bx--overflow-menu bx--toolbar-action"
            :data   = "data"
            :worksheet = "title"
            :name    = "title +'.xls'">
            <svg fill-rule="evenodd" height="16" name="download" role="img" viewBox="0 0 14 16" width="14" aria-label="Download" alt="Download">
              <title>Download</title>
              <path d="M7.506 11.03l4.137-4.376.727.687-5.363 5.672-5.367-5.67.726-.687 4.14 4.374V0h1v11.03z"></path>
              <path d="M13 15v-2h1v2a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-2h1v2h12z"></path>
            </svg>
          </export-excel>
          <slot name="action-buttons"></slot>
        </template>
        <template slot="data">
          <cv-data-table-row
            v-for="(row, rowIndex) in filteredData"
            :key="`${rowIndex}`"
            :value="`${rowIndex}`"
          >
            <cv-data-table-cell
              v-for="(cell, cellIndex) in row"
              :key="`${cellIndex}`"
              :value="`${cellIndex}`"
            >
              <div v-if="cellIndex == 'date'">
                <cv-definition-tooltip
                  :definition="getTime(cell*1000)"
                  :term="getRelativeTime(cell*1000)"
                />
              </div>
              <div v-else-if="cellIndex == 'name' && clickableName">
                <cv-link
                  style="cursor: pointer;"
                  @click="onClick(row)"
                >
                  {{ cell }}
                </cv-link>
              </div>
              <div v-else-if="cellIndex == 'status'">
                <cv-tag
                  v-if="cell==='0'"
                  kind="gray"
                  label="Onay Bekliyor"
                />
                <cv-tag
                  v-else-if="cell==='1'"
                  kind="green"
                  label="Onaylandı"
                />
                <cv-tag
                  v-else-if="cell==='2'"
                  kind="red"
                  label="Reddedildi"
                />
              </div>
              <div v-else>{{ cell }}</div>
            </cv-data-table-cell>
            <cv-data-table-cell v-if="type == 'lecturer'">
                <cv-button
                    kind="ghost"
                    @click="approveStudent(row)"
                  >
                    <i
                      style="color: #01941d"
                      class="fa-solid fa-check"
                    ></i>
                  </cv-button>
                  <cv-button
                    kind="ghost"
                    @click="declineStudent(row)"
                  >
                    <i
                      style="color: #fc0303"
                      class="fa-solid fa-x"
                    ></i>
                  </cv-button>
              </cv-data-table-cell>
          </cv-data-table-row>
        </template>
      </cv-data-table>
    </div>
  </div>
</template>

<script>
export default {
  name: "data-table",
  props: {
    title: {
      type: String,
      default: "",
    },
    api: {
      type: String,
    },
    id: {
      type: String,
      default: () => null,
    },
    columns: {
      type: Array,
      default: () => ["Severity", "Name", "Date", "By"],
    },
    size: {
      type: Number,
      default: () => 5,
    },
    filter: {
      type: Object,
      default: () => ({}),
    },
    sortable: {
      type: Boolean,
      default: () => true,
    },
    searchable: {
      type: Boolean,
      default: () => true,
    },
    showPagination: {
      type: Boolean,
      default: () => true,
    },
    showTitle: {
      type: Boolean,
      default: () => true,
    },
    clickableName: {
      type: Boolean,
      default: () => false,
    },
    onClick: { type: Function },
    type: { type: String },
    lectureCode: { type: String },
  },
  data() {
    return {
      data: [],
      count: "",
      loading: true,
      start: 0,
      search: "",
      pageSize: this.size,
      json_fields: {
        'Complete name': 'name',
        'City': 'city',
        'Telephone': 'phone.mobile',
        'Telephone 2' : {
            field: 'phone.landline',
            callback: (value) => {
                return `Landline Phone - ${value}`;
            }
        },
      },
      json_data: [
            {
                'name': 'Tony Peña',
                'city': 'New York',
                'country': 'United States',
                'birthdate': '1978-03-15',
                'phone': {
                    'mobile': '1-541-754-3010',
                    'landline': '(541) 754-3010'
                }
            },
            {
                'name': 'Thessaloniki',
                'city': 'Athens',
                'country': 'Greece',
                'birthdate': '1987-11-23',
                'phone': {
                    'mobile': '+1 855 275 5071',
                    'landline': '(2741) 2621-244'
                }
            }
        ],
        json_meta: [
            [
                {
                    'key': 'charset',
                    'value': 'utf-8'
                }
            ]
        ],
    };
  },
  computed: {
    pagination() {
      return {
        numberOfItems: this.availableOptions.length,
        pageSizes: [...Array(5).keys()].map((i) => i * 5 + this.size),
      };
    },
    filteredData() {
      if (this.id != null) {
        this.data.forEach((e) => {
          delete e.by;
        });
      }
      return this.availableOptions.slice(
        this.start,
        this.start + this.pageSize
      );
    },
    availableOptions() {
      const criteria = this.search;
      const filter = this.filter;
      let table = this.data;
      if (filter["severity"]) {
        table = table.filter((item) => item["severity"] == filter["severity"]);
      }
      if (filter["date"]) {
        table = table.filter((item) => item["date"] >= filter["date"]);
      }
      if (criteria) {
        table = table.filter((item) =>
          Object.keys(item)
            .map((key) => item[key].toLowerCase().includes(criteria))
            .includes(true)
        );
      }
      return table;
    },
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      let form = new FormData();
      form.append("id", this.id);
      request(
        API(this.api),
        form,
        (res) => {
          let response = JSON.parse(res).message;
          this.count = response.length;
          this.data = response;
          this.loading = false;
        },
        () => {
          this.loading = false;
        }
      );
    },
    approveStudent(row) {
      let form = new FormData();
      form.append("studentid", row.studentid);
      form.append("lecturecode", this.lectureCode);
      request(
        API('approve_student'),
        form,
        () => {
          showSwal("Onay başarılı", "success", 2000);
          this.sendNotificationApprove(row);
          setTimeout(() => {
            location.reload();
            }, 2000);
        },
        () => {
          let error = JSON.parse(res);
          showSwal(error.message, "error", 3000);
        }
      );
    },
    declineStudent(row) {
      let form = new FormData();
      form.append("studentid", row.studentid);
      form.append("lecturecode", this.lectureCode);
      request(
        API('decline_student'),
        form,
        () => {
          showSwal("Reddetme başarılı", "success", 2000);
          this.sendNotificationDecline(row);
          setTimeout(() => {
            location.reload();
            }, 2000);
        },
        () => {
          let error = JSON.parse(res);
          showSwal(error.message, "error", 3000);
        }
      );
    },
    sendNotificationApprove: function (row) {
      let form = new FormData();
      form.append("userid", row.studentid);
      form.append("title", 'Dersiniz Onaylandı');
      form.append("message", this.lectureCode + 'kodlu ders kaydınız onaylanmıştır.');
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
    sendNotificationDecline: function (row) {
      let form = new FormData();
      form.append("userid", row.studentid);
      form.append("title", 'Dersiniz Onaylanmadı');
      form.append("message", this.lectureCode + 'kodlu ders kaydınız onaylamanmıştır.');
      form.append("type", "health_problem");      
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
    actionOnPagination(val) {
      this.pageSize = val.length;
      this.start = val.start - 1;
    },
    onCauseClick: function (cell) {
      let id = cell.split("@")[1];
      this.$router.push({
        path: `/hosts/${id}/general`,
      });
    },
    onSort(sortBy) {
      this.availableOptions.sort((a, b) => {
        let key = this.columns[sortBy.index].toLowerCase();
        if (sortBy.order === "descending") {
          return b[key].localeCompare(a[key]);
        } else if (sortBy.order === "ascending") {
          return a[key].localeCompare(b[key]);
        } else {
          return 0;
        }
      });
    },
  },
};
</script>