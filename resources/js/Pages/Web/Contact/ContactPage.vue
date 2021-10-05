<template>
  <div>
    <contact-info></contact-info>
    <contact-form></contact-form>
  </div>
</template>
<script>
import ContactInfo from "./ContactInfo.vue";
import ContactForm from "./ContactForm.vue";

export default {
  components: {
    ContactInfo,
    ContactForm,
  },
};
</script>