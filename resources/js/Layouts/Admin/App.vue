<template>
  <div class="flex flex-row" v-if="isLoggedIn">
    <alert></alert>
    <confirm-alert></confirm-alert>
    <div
      class="w-5/6 lg:w-1/5 fixed lg:relative min-h-screen z-10"
      v-if="showSideBar"
    >
      <side-bar
        @toggelSideBar="toggelSideBar"
        :showSideBar="showSideBar"
      ></side-bar>
    </div>
    <div class="flex-grow">
      <!-- overlay -->
      <div
        class="
          overlay
          fixed
          lg:hidden
          w-full
          h-screen
          bg-black
          opacity-80
          cursor-pointer
        "
        v-if="showSideBar"
        @click="toggelSideBar"
      ></div>
      <nav-bar
        @toggelSideBar="toggelSideBar"
        :showSideBar="showSideBar"
      ></nav-bar>
      <content>
        <router-view></router-view>
      </content>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import NavBar from "./Bars/NavBar.vue";
import SideBar from "./Bars/SideBar.vue";
import Content from "./Content/Content.vue";

export default {
  components: {
    NavBar,
    SideBar,
    Content,
  },

  data() {
    return {
      showSideBar: false,
    };
  },

  computed: {
    ...mapGetters({ isLoggedIn: "admin/isLoggedIn" }),
  }, //end of computed

  methods: {
    toggelSideBar() {
      this.showSideBar = !this.showSideBar;
    }, //end of toggleSideBar
  }, //end of sidebar

  async beforeRouteEnter(to, from, next) {
    localStorage.removeItem("user");
    try {
      let user = (await axios.get("/user")).data;
      localStorage.setItem("user", JSON.stringify(user));
      next();
    } catch (error) {
      if (error.response.status == 401) {
        next({ name: "admin.login" });
      }
      if (error.response.status == 403) {
        next({ name: "forbidden" });
      }
    } //end of register a user to the front
  }, //end of beforeRouteEnter

  created() {
    this.$store.dispatch("admin/login");
  }, //end of created
};
</script>