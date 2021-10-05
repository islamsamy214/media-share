<template>
  <loading v-if="loading"></loading>
  <blog-category-form v-else :blogCategory="blogCategory"></blog-category-form>
</template>

<script>
import BlogCategoryForm from "./BlogCategoryForm.vue";

export default {
  components: {
    BlogCategoryForm,
  },

  data() {
    return {
      loading: true,
      blogCategory: null,
    };
  }, //end of data

  methods: {
    getBlogCategory() {
      axios
        .get(`/api/admin/blogcategories/${this.$route.params.id}/edit`)
        .then((response) => {
          this.blogCategory = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  beforeRouteEnter(to, from, next) {
    if (from.name != "admin.blogcategories") {
      next({ name: "admin.blogcategories" });
    } else {
      next();
    }
  }, //end of before route enter

  created() {
    this.getBlogCategory();
  }, //end of created
};
</script>