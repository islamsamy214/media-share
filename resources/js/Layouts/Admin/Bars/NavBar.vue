<template>
  <nav class="w-full p-4 bg-primary text-white flex justify-between flex-row">
    <button @click="$emit('toggelSideBar')" class="inline">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h8m-8 6h16"
        />
      </svg>
    </button>
    <buttons-list>
      <template #title>
        {{ user.name }}
        <icon icon="bx:bx-chevron-down" class="inline w-6 h-6" />
      </template>
      <template #>
        <router-link
          :to="{
            name: 'admin.users.edit.profile',
            query: { slug: user.slug, id: user.id },
          }"
          class="button-list"
          >profile</router-link
        >
        <button class="button-list" @click="logout">logout</button>
      </template>
    </buttons-list>
  </nav>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  emits: ["toggelSideBar"],

  data() {
    return {
      isVisible: false,
    };
  },

  computed: {
    ...mapGetters({
      user: "admin/getUser",
    }), //end of mapGetters
  }, //end of computed

  methods: {
    logout() {
      this.$store.dispatch("admin/logout");
      axios
        .post("/logout")
        .then((response) => {
          this.$router.push({ name: "home" });
        })
        .catch((error) => {
          console.log(error.response);
        });
    },
  },
};
</script>