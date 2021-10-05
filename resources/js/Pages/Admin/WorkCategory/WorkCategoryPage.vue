<template>
  <loading v-if="loading"></loading>
  <div class="flex flex-col" v-else>
    <work-category-nav
      :total="total"
      @submitSearch="submitSearch"
    ></work-category-nav>
    <work-category-table
      :workCategories="workCategories"
      :isEmpty="isEmpty"
      :currentPage="currentPage"
      :firstPage="firstPage"
      :lastPage="lastPage"
      @previuosPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
      @reloadWorkCategorys="changePage"
    ></work-category-table>
  </div>
</template>

<script>
import WorkCategoryNav from "./WorkCategoryNav.vue";
import WorkCategoryTable from "./WorkCategoryTable.vue";

export default {
  components: {
    WorkCategoryNav,
    WorkCategoryTable,
  },

  data() {
    return {
      workCategories: [],
      loading: true,
      isEmpty: false,
      //pagination
      currentPage: null,
      firstPage: null,
      lastPage: null,
      pages: [],
      total: 0,
      //workcategory permissions
    };
  }, //end of data

  methods: {
    getWorkCategories(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
      this.total = response.total;
      this.workCategories = response.data;
    }, //end of getWorkCategorys

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
    submitSearch(search) {
      this.search = search;
      this.changePage();
    },
    //end of search

    changePage(page) {
      typeof page === "undefined" ? (page = 1) : page;
      let URL = this.generateUrl(page);
      this.getData(URL);
    }, //end of stablish the URL

    generateUrl(page) {
      let URL = `/api/admin/workcategories?page=${page}`;
      if (this.search) {
        URL += `&search=${this.search}`;
      }
      return URL;
    }, //end of generateUrl

    getData(URL) {
      axios
        .get(URL)
        .then((response) => {
          this.getWorkCategories(response.data);
          this.getPaginator(response.data);
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  created() {
    this.getData("/api/admin/workcategories");
  },
};
</script>