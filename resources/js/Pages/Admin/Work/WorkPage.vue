<template>
  <loading v-if="loading"></loading>
  <div class="flex flex-col" v-else>
    <work-nav
      :total="total"
      :workCategories="workCategories"
      @submitSearch="submitSearch"
    ></work-nav>
    <work-table
      :works="works"
      :isEmpty="isEmpty"
      :currentPage="currentPage"
      :firstPage="firstPage"
      :lastPage="lastPage"
      @previuosPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
      @reloadWorks="changePage"
    ></work-table>
  </div>
</template>

<script>
import WorkNav from "./WorkNav.vue";
import WorkTable from "./WorkTable.vue";

export default {
  components: {
    WorkNav,
    WorkTable,
  },

  data() {
    return {
      works: [],
      workCategories: [],
      loading: true,
      isEmpty: false,
      //pagination
      currentPage: null,
      firstPage: null,
      lastPage: null,
      pages: [],
      total: 0,
      //work permissions
    };
  }, //end of data

  methods: {
    getWorks(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
      this.total = response.total;
      this.works = response.data;
    }, //end of getWorks

    getWorkCategories(data) {
      this.workCategories = data;
    }, //end of getWorks

    getPaginator(response) {
      this.pages = [];
      for (let resPage = 1; resPage <= response.last_page; resPage++) {
        this.pages.push(resPage);
      }
      this.currentPage = response.current_page;
      this.firstPage = response.first_page_url.split("?")[1].split("=")[1];
      this.lastPage = response.last_page;
    }, //end of getPaginator

    //start of search
    submitSearch(search, searchCategories) {
      this.search = search;
      this.searchCategories = searchCategories;
      this.changePage();
    },
    //end of search

    changePage(page) {
      typeof page === "undefined" ? (page = 1) : page;
      let URL = this.generateUrl(page);
      this.getData(URL);
    }, //end of stablish the URL

    generateUrl(page) {
      let URL = `/api/admin/works?page=${page}`;
      if (this.search) {
      }
      if (this.search && this.searchCategories) {
        URL += `&search=${this.search}&searchcategories=${this.searchCategories}`;
      } else if (this.search) {
        URL += `&search=${this.search}`;
      } else if (this.searchCategories) {
        URL += `&searchcategories=${this.searchCategories}`;
      }
      return URL;
    }, //end of generateUrl

    getData(URL) {
      axios
        .get(URL)
        .then((response) => {
          this.getWorks(response.data.works);
          this.getWorkCategories(response.data.work_categories);
          this.getPaginator(response.data.works);
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  created() {
    this.getData("/api/admin/works");
  },
};
</script>