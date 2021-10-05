<template>
  <loading v-if="loading"></loading>
  <profile-form v-else :user="user"></profile-form>
</template>

<script>
import ProfileForm from "./ProfileForm.vue";

export default {
  components: {
    ProfileForm,
  },

  data() {
    return {
      loading: true,
      user: null,
    };
  }, //end of data

  methods: {
    getUser() {
      if (this.$route.params.id) {
        axios
          .get(`/api/admin/users/${this.$route.params.id}/edit`)
          .then((response) => {
            this.user = response.data;
          })
          .then(() => {
            this.loading = false;
          });
      }
    },
  }, //end of methods

  beforeCreate() {
    if (this.$route.params.id == undefined) {
      this.$router.push({ name: "admin.dashboard" });
    }
  }, //end of before create

  created() {
    this.getUser();
  }, //end of created
};
</script>