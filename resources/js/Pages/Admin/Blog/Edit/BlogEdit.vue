<template>
  <loading v-if="loading"></loading>
  <blog-form v-else :blog="blog" :blogCategories="blogCategories"></blog-form>
</template>

<script>
import BlogForm from "./BlogForm.vue";

export default {
  components: {
    BlogForm,
  },

  data() {
    return {
      loading: true,
      blog: null,
      blogCategories: null,
    };
  }, //end of data

  methods: {
    getBlog() {
      axios
        .get(`/api/admin/blogs/${this.$route.query.id}/edit`)
        .then((response) => {
          this.blog = response.data.blog;
          this.blogCategories = response.data.blogCategories;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  beforeRouteEnter(to, from, next) {
    if (from.name != "admin.blogs.show") {
      next({ name: "admin.blogs" });
    } else {
      next();
    }
  }, //end of before route enter

  created() {
    this.getBlog();
  }, //end of created
};
</script>