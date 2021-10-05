<template>
  <loading v-if="loading"></loading>
  <div class="flex flex-col" v-else>
    <user-nav :total="total" @submitSearch="submitSearch"></user-nav>
    <user-table
      :users="users"
      :isEmpty="isEmpty"
      :currentPage="currentPage"
      :firstPage="firstPage"
      :lastPage="lastPage"
      @previuosPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
      @reloadUsers="changePage"
    ></user-table>
  </div>
</template>

<script>
import UserNav from "./UserNav.vue";
import UserTable from "./UserTable.vue";

export default {
  components: {
    UserNav,
    UserTable,
  },

  data() {
    return {
      users: [],
      loading: true,
      isEmpty: false,
      //pagination
      currentPage: null,
      firstPage: null,
      lastPage: null,
      pages: [],
      total: 0,
    };
  }, //end of data

  methods: {
    getUsers(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
      this.total = response.total;
      this.users = response.data;
    }, //end of getUsers

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
      let URL = `/api/admin/users?page=${page}`;
      if (this.search) {
        URL += `&search=${this.search}`;
      }
      return URL;
    }, //end of generateUrl

    getData(URL) {
      axios
        .get(URL)
        .then((response) => {
          this.getUsers(response.data);
          this.getPaginator(response.data);
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  created() {
    this.getData("/api/admin/users");
  },
};
</script>