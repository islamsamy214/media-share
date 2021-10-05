<template>
  <loading v-if="loading"></loading>
  <div class="flex flex-col" v-else>
    <blog-category-nav
      :total="total"
      @submitSearch="submitSearch"
    ></blog-category-nav>
    <blog-category-table
      :blogCategories="blogCategories"
      :isEmpty="isEmpty"
      :currentPage="currentPage"
      :firstPage="firstPage"
      :lastPage="lastPage"
      @previuosPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
      @reloadBlogCategorys="changePage"
    ></blog-category-table>
  </div>
</template>

<script>
import BlogCategoryNav from "./BlogCategoryNav.vue";
import BlogCategoryTable from "./BlogCategoryTable.vue";

export default {
  components: {
    BlogCategoryNav,
    BlogCategoryTable,
  },

  data() {
    return {
      blogCategories: [],
      loading: true,
      isEmpty: false,
      //pagination
      currentPage: null,
      firstPage: null,
      lastPage: null,
      pages: [],
      total: 0,
      //blogcategory permissions
    };
  }, //end of data

  methods: {
    getBlogCategories(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
      this.total = response.total;
      this.blogCategories = response.data;
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
      let URL = `/api/admin/blogcategories?page=${page}`;
      if (this.search) {
        URL += `&search=${this.search}`;
      }
      return URL;
    }, //end of generateUrl

    getData(URL) {
      axios
        .get(URL)
        .then((response) => {
          this.getBlogCategories(response.data);
          this.getPaginator(response.data);
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  created() {
    this.getData("/api/admin/blogcategories");
  },
};
</script>