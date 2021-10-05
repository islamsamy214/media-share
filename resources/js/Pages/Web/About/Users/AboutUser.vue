<template>
  <loading v-if="loading"></loading>
  <div class="flex flex-col">
    <about-user-nav @submitSearch="submitSearch"></about-user-nav>
    <about-user-list :users="users"></about-user-list>
    <about-user-paginator
      :lastPage="lastPage"
      :firstPage="firstPage"
      :currentPage="currentPage"
      @previousPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
    ></about-user-paginator>
  </div>
</template>

<script>
import AboutUserNav from "./AboutUserNav.vue";
import AboutUserList from "./AboutUserList.vue";
import AboutUserPaginator from "./AboutUserPaginator.vue";

export default {
  components: {
    AboutUserNav,
    AboutUserList,
    AboutUserPaginator,
  },

  data() {
    return {
      loading: true,
      users: null,
      //pagination
      currentPage: null,
      firstPage: null,
      lastPage: null,
      pages: [],
    };
  }, //end of data

  methods: {
    getUsers(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
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
      this.loading = true;
      typeof page === "undefined" ? (page = 1) : page;
      let URL = this.generateUrl(page);
      this.getData(URL);
    }, //end of stablish the URL

    generateUrl(page) {
      let URL = `/api/users?page=${page}`;
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
    this.getData("/api/users");
  },
};
</script>