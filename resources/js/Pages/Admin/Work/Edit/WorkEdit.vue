<template>
  <loading v-if="loading"></loading>
  <work-form v-else :work="work" :workCategories="workCategories"></work-form>
</template>

<script>
import WorkForm from "./WorkForm.vue";

export default {
  components: {
    WorkForm,
  },

  data() {
    return {
      loading: true,
      work: null,
      workCategories: null,
    };
  }, //end of data

  methods: {
    getWork() {
      axios
        .get(`/api/admin/works/${this.$route.params.id}/edit`)
        .then((response) => {
          this.work = response.data.work;
          this.workCategories = response.data.workCategories;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  beforeRouteEnter(to, from, next) {
    if (from.name != "admin.works.show") {
      next({ name: "admin.works" });
    } else {
      next();
    }
  }, //end of before route enter

  created() {
    this.getWork();
  }, //end of created
};
</script>