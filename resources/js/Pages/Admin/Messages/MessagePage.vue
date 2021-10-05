<template>
  <loading v-if="loading"></loading>
  <div v-else>
    <message-nav :total="total" @submitSearch="submitSearch"></message-nav>
    <message-contact :contact="contact"></message-contact>
    <message-table
      :messages="messages"
      :isEmpty="isEmpty"
      :currentPage="currentPage"
      :firstPage="firstPage"
      :lastPage="lastPage"
      @previuosPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
      @reloadMessages="changePage"
    ></message-table>
  </div>
</template>
<script>
import MessageNav from "./MessageNav.vue";
import MessageContact from "./MessageContact.vue";
import MessageTable from "./MessageTable.vue";

export default {
  components: {
    MessageNav,
    MessageContact,
    MessageTable,
  }, //end of componenets

  data() {
    return {
      messages: [],
      loading: true,
      isEmpty: false,
      //pagination
      currentPage: null,
      firstPage: null,
      lastPage: null,
      pages: [],
      total: 0,
      //contact data
      contact: null,
    };
  }, //end of data

  methods: {
    getMessages(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
      this.total = response.total;
      this.messages = response.data;
    }, //end of getBlogCategorys

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
      let URL = `/api/admin/messages?page=${page}`;
      if (this.search) {
        URL += `&search=${this.search}`;
      }
      return URL;
    }, //end of generateUrl

    getData(URL) {
      axios.get(URL).then((response) => {
        this.getMessages(response.data);
        this.getPaginator(response.data);
        this.getContact();
      });
    },

    getContact() {
      axios
        .get(`/api/admin/contacts`)
        .then((response) => {
          this.contact = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of getContact
  }, //end of methods

  created() {
    this.getData("/api/admin/messages");
  },
};
</script>