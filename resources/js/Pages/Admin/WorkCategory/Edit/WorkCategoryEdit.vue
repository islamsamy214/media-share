<template>
  <loading v-if="loading"></loading>
  <work-category-form v-else :workCategory="workCategory"></work-category-form>
</template>

<script>
import WorkCategoryForm from "./WorkCategoryForm.vue";

export default {
  components: {
    WorkCategoryForm,
  },

  data() {
    return {
      loading: true,
      workCategory: null,
    };
  }, //end of data

  methods: {
    getWorkCategory() {
      axios
        .get(`/api/admin/workcategories/${this.$route.params.id}/edit`)
        .then((response) => {
          this.workCategory = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  beforeRouteEnter(to, from, next) {
    if (from.name != "admin.workcategories") {
      next({ name: "admin.workcategories" });
    } else {
      next();
    }
  }, //end of before route enter

  created() {
    this.getWorkCategory();
  }, //end of created
};
</script>