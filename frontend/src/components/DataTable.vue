<template>
  <div>
    <h5 v-if="title">
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
                  v-if="cell==='2'"
                  kind="gray"
                  label="Down"
                />
                <cv-tag
                  v-else-if="cell==='1'"
                  kind="green"
                  label="Up"
                />
              </div>
              <div v-else>{{ cell }}</div>
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
    clickableName: {
      type: Boolean,
      default: () => false,
    },
    onClick: { type: Function },
  },
  data() {
    return {
      data: [],
      count: "",
      loading: true,
      start: 0,
      search: "",
      pageSize: this.size,
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
    getTime(s) {
      let d = new Date(s);
      let str = d.toUTCString();
      return str.substring(0, str.lastIndexOf(" "));
    },
    getRelativeTime(d1, d2 = new Date()) {
      var units = {
        year: 24 * 60 * 60 * 1000 * 365,
        month: (24 * 60 * 60 * 1000 * 365) / 12,
        day: 24 * 60 * 60 * 1000,
        hour: 60 * 60 * 1000,
        minute: 60 * 1000,
        second: 1000,
      };
      var rtf = new Intl.RelativeTimeFormat("en", { numeric: "auto" });
      var elapsed = d1 - d2;
      for (var u in units)
        if (Math.abs(elapsed) > units[u] || u == "second")
          return rtf.format(Math.round(elapsed / units[u]), u);
    },
  },
};
</script>