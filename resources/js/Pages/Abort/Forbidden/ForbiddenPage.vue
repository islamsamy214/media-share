<template>
  <div
    class="text-lg w-screen h-screen flex flex-col justify-center items-center"
  >
    <div class="m-4">
      <span class="border-r-2 border-secondary p-4">403</span>
      <span class="p-4">you are forbidden</span>
    </div>
    <div class="m-4">
      <router-link
        :to="{ name: 'home' }"
        class="
          p-4
          flex
          items-center
          transition
          opacity-80
          hover:text-secondary
          hover:opacity-100
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 m-1 inline"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
          />
        </svg>
        <span>home</span></router-link
      >
      <button
        class="
          p-4
          flex
          items-center
          transition
          opacity-80
          hover:text-secondary
          hover:opacity-100
        "
        v-if="isLoggedInSession"
        @click="logout"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 m-1 inline"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
          />
        </svg>
        <span>logout</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isLoggedInSession: JSON.parse(localStorage.getItem("isLoggedInSession")),
    };
  }, //end of data

  methods: {
    logout() {
      localStorage.removeItem("isLoggedInSession");
      axios.post("/logout").then((response) => {
        this.$router.push({ name: "home" });
      });
    },
  }, //end of methods

  async beforeCreate() {
    try {
      (await axios.get("/user")).data;
      localStorage.setItem("isLoggedInSession", true);
    } catch (error) {
      if (error.response.status == 401) {
        this.$router.push({ name: "admin.login" });
      }
      if (error.response.status == 403) {
        localStorage.setItem("isLoggedInSession", true);
      }
    }
  }, //end of beforeCreated
};
</script>