<template>
  <loading v-if="loading"></loading>
  <contact-form v-else :contact="contact"></contact-form>
</template>

<script>
import ContactForm from "./ContactForm.vue";

export default {
  components: {
    ContactForm,
  }, //end of components

  data() {
    return {
      loading: true,
      contact: null,
    };
  }, //end of data

  methods: {
    getContact() {
      axios
        .get(`/api/admin/contacts/${1}/edit`)
        .then((response) => {
          this.contact = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of getContacts
  }, //end of methods

  created() {
    this.getContact();
  },
};
</script>