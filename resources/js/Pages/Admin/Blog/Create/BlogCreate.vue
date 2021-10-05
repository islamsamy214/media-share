<template>
  <loading v-if="loading"></loading>
  <blog-form v-else :blogCategories="blogCategories"></blog-form>
</template>

<script>
import BlogForm from "./BlogForm.vue";

export default {
  components: {
    BlogForm,
  }, //end of components

  data() {
    return {
      loading: true,
      blogCategories: null,
    };
  }, //end of data

  created() {
    axios.get("/api/admin/getblogcategories").then((response) => {
      this.blogCategories = response.data;
      this.loading = false;
    });
  }, //end of created
};
</script>