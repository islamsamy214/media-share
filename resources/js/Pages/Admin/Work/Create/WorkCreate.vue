<template>
  <loading v-if="loading"></loading>
  <work-form v-else :workCategories="workCategories"></work-form>
</template>

<script>
import WorkForm from "./WorkForm.vue";

export default {
  components: {
    WorkForm,
  }, //end of components

  data() {
    return {
      loading: true,
      workCategories: null,
    };
  }, //end of data

  created() {
    axios.get("/api/admin/getworkcategories").then((response) => {
      this.workCategories = response.data;
      this.loading = false;
    });
  }, //end of created
};
</script>