<template>
  <loading v-if="loading"></loading>
  <user-form v-else :user="user"></user-form>
</template>

<script>
import UserForm from "./UserForm.vue";

export default {
  components: {
    UserForm,
  },

  data() {
    return {
      loading: true,
      user: null,
    };
  }, //end of data

  methods: {
    getUser() {
      axios
        .get(`/api/admin/users/${this.$route.params.id}/edit`)
        .then((response) => {
          this.user = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  beforeRouteEnter(to, from, next) {
    if (from.name != "admin.users") {
      next({ name: "admin.users" });
    } else {
      next();
    }
  }, //end of before route enter

  created() {
    this.getUser();
  }, //end of created
};
</script>