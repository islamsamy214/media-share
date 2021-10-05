<template>
  <loading v-if="loading"></loading>
  <div class="flex flex-col">
    <blog-nav
      :blogCategories="blogCategories"
      @submitSearch="submitSearch"
    ></blog-nav>
    <blog-table
      :blogs="blogs"
      :isEmpty="isEmpty"
      :currentPage="currentPage"
      :firstPage="firstPage"
      :lastPage="lastPage"
      @previuosPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
      @reloadBlogs="changePage"
    ></blog-table>
  </div>
</template>

<script>
import BlogNav from "./BlogNav.vue";
import BlogTable from "./BlogTable.vue";

export default {
  components: {
    BlogNav,
    BlogTable,
  },

  data() {
    return {
      blogs: [],
      blogCategories: [],
      loading: true,
      isEmpty: false,
      //pagination
      currentPage: null,
      firstPage: null,
      lastPage: null,
      pages: [],
      //blog permissions
    };
  }, //end of data

  methods: {
    getBlogs(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
      this.total = response.total;
      this.blogs = response.data;
    }, //end of getBlogs

    getBlogCategories(data) {
      this.blogCategories = data;
    }, //end of getBlogs

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
      this.loading = true;
      typeof page === "undefined" ? (page = 1) : page;
      let URL = this.generateUrl(page);
      this.getData(URL);
    }, //end of stablish the URL

    generateUrl(page) {
      let URL = `/api/blogs?page=${page}`;
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
          this.getBlogs(response.data.blogs);
          this.getBlogCategories(response.data.blog_categories);
          this.getPaginator(response.data.blogs);
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  created() {
    this.getData("/api/blogs");
  },
};
</script>