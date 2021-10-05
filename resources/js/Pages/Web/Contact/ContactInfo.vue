<template>
  <loading v-if="loading"></loading>
  <div class="flex flex-col lg:flex-row" v-else>
    <div class="flex my-2 lg:mr-2 p-3 bg-black rounded-xl w-full overflow-auto">
      <!-- headers -->
      <div class="w-1/2">
        <div>
          <h2 class="m-1">email</h2>
          <h2 class="m-1">facebook</h2>
          <h2 class="m-1">twitter</h2>
        </div>
      </div>
      <!-- values -->
      <div class="w-1/2">
        <div class="w-full text-right float-right">
          <h2 class="transition m-1 hover:text-secondary">
            <a :href="'mailto:' + contact.email">{{ contact.email }}</a>
          </h2>
          <h2 class="transition m-1 hover:text-secondary">
            <a :href="`https://www.facebook.com/${contact.facebook_id}`" target="_blank">{{
              contact.facebook_id
            }}</a>
          </h2>
          <h2 class="transition m-1 hover:text-secondary">
            <a :href="`https://www.twitter.com/${contact.twitter_id}`" target="_blank">{{
              contact.twitter_id
            }}</a>
          </h2>
        </div>
      </div>
    </div>
    <div class="flex my-2 lg:ml-2 p-3 bg-black rounded-xl w-full overflow-auto">
      <!-- headers -->
      <div class="w-1/2">
        <div>
          <h2 class="m-1">linkedin</h2>
          <h2 class="m-1">youtube</h2>
          <h2 class="m-1">instagram</h2>
        </div>
      </div>
      <!-- values -->
      <div class="w-1/2">
        <div class="w-full text-right float-right">
          <h2 class="transition m-1 hover:text-secondary">
            <a :href="`https://www.linkedin.com/${contact.linkedin_id}`" target="_blank">{{
              contact.linkedin_id
            }}</a>
          </h2>
          <h2 class="transition m-1 hover:text-secondary">
            <a :href="`https://www.youtube.com/${contact.youtube_id}`" target="_blank">{{
              contact.youtube_id
            }}</a>
          </h2>
          <h2 class="transition m-1 hover:text-secondary">
            <a :href="`https://www.instagram.com/${contact.instagram_id}`" target="_blank">{{
              contact.instagram_id
            }}</a>
          </h2>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: true,
      contact: null,
    };
  }, //end of data

  methods: {
    getContacts() {
      axios
        .get(`/api/contacts`)
        .then((response) => {
          this.contact = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  created() {
    this.getContacts();
  }, //end of created
};
</script>