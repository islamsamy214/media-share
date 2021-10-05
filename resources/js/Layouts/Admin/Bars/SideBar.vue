<template>
  <div class="transition transform h-screen lg:h-full bg-primary text-white">
    <div class="p-4 py-7 mx-auto text-center">
      <img
        v-if="user"
        class="inline rounded-full h-36 w-36"
        :src="user.image_path"
      />
      <span class="block mt-5" v-if="user">{{ user.name }}</span>
    </div>

    <div>
      <ul class="flex flex-col">
        <li class="hover:bg-black" :class="activeDashboard">
          <router-link
            class="block items-center p-4"
            :to="{ name: `admin.dashboard` }"
          >
            <icon icon="dashicons:dashboard" class="w-5 h-5 inline mb-1 mr-3" />

            <span> Dashboard </span>
          </router-link>
        </li>
        <li
          class="hover:bg-black"
          :class="activeUsers"
          v-if="
            user.permissions.some(
              (permission) => permission.name == 'read_users'
            )
          "
        >
          <router-link
            class="block h-full w-full p-4"
            :to="{ name: `admin.users` }"
          >
            <icon icon="entypo:users" class="w-5 h-5 inline mb-1 mr-3" />
            <span> Users </span>
          </router-link>
        </li>
        <li
          class="hover:bg-black"
          :class="activeBlogCategories"
          v-if="
            user.permissions.some(
              (permission) => permission.name == 'read_blog_categories'
            )
          "
        >
          <router-link
            class="block h-full w-full p-4"
            :to="{ name: `admin.blogcategories` }"
          >
            <icon icon="ls:category" class="w-5 h-5 inline mb-1 mr-3" />

            <span> Blog Categories </span>
          </router-link>
        </li>
        <li
          class="hover:bg-black"
          :class="activeBlogs"
          v-if="
            user.permissions.some(
              (permission) => permission.name == 'read_blogs'
            )
          "
        >
          <router-link
            class="block h-full w-full p-4"
            :to="{ name: `admin.blogs` }"
          >
            <icon icon="bx:bxl-blogger" class="w-5 h-5 inline mb-1 mr-3" />

            <span> Blogs </span>
          </router-link>
        </li>
        <li
          class="hover:bg-black"
          :class="activeWorkCategories"
          v-if="
            user.permissions.some(
              (permission) => permission.name == 'read_work_categories'
            )
          "
        >
          <router-link
            class="block h-full w-full p-4"
            :to="{ name: `admin.workcategories` }"
          >
            <icon icon="ls:category" class="w-5 h-5 inline mb-1 mr-3" />

            <span> Work Categories </span>
          </router-link>
        </li>
        <li
          class="hover:bg-black"
          :class="activeWorks"
          v-if="
            user.permissions.some(
              (permission) => permission.name == 'read_works'
            )
          "
        >
          <router-link
            class="block h-full w-full p-4"
            :to="{ name: `admin.works` }"
          >
            <icon icon="dashicons:laptop" class="w-5 h-5 inline mb-1 mr-3" />

            <span> Works </span>
          </router-link>
        </li>
        <li
          class="hover:bg-black"
          :class="activeMessages"
          v-if="
            user.permissions.some(
              (permission) => permission.name == 'read_messages'
            )
          "
        >
          <router-link
            class="block h-full w-full p-4"
            :to="{ name: `admin.messages` }"
          >
            <icon
              icon="simple-icons:googlemessages"
              class="w-5 h-5 inline mb-1 mr-3"
            />

            <span> Messages </span>
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: ["showSideBar"],

  computed: {
    ...mapGetters({
      user: "admin/getUser",
    }), //end of user mapping

    activeDashboard() {
      return { "active-link": this.$route.name == "admin.dashboard" };
    }, //end of activeDashboard

    activeUsers() {
      return { "active-link": this.$route.name == "admin.users" };
    }, //end of activeUsers

    activeBlogCategories() {
      return { "active-link": this.$route.name == "admin.blogcategories" };
    }, //end of activeBlogCategories

    activeBlogs() {
      return { "active-link": this.$route.name == "admin.blogs" };
    }, //end of activeBlogs

    activeWorkCategories() {
      return { "active-link": this.$route.name == "admin.workcategories" };
    }, //end of activeWorkCategories

    activeWorks() {
      return { "active-link": this.$route.name == "admin.works" };
    }, //end of activeWorks

    activeMessages() {
      return { "active-link": this.$route.name == "admin.messages" };
    }, //end of activeMessages
  }, //end of computed
};
</script>