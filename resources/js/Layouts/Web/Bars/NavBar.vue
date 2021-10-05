<template>
  <div class="w-screen bg-primary shadow">
    <div class="w-full flex justify-end">
      <button
        class="transition md:hidden p-4 hover:text-secondary"
        @click="visibleLinks = !visibleLinks"
      >
        <icon icon="icon-park-outline:mindmap-list" class="w-6 h-6" />
      </button>
    </div>
    <div
      class="w-full flex flex-col md:flex-row md:justify-center uppercase"
      :class="{ 'hidden md:flex': !visibleLinks }"
    >
      <router-link
        :to="{ name: 'about' }"
        class="transition hover:text-secondary p-4"
        :class="activeAbout"
        >about</router-link
      >
      <router-link
        :to="{ name: 'blogs' }"
        class="transition hover:text-secondary p-4"
        :class="activeBlogs"
        >blogs</router-link
      >
      <router-link
        :to="{ name: 'works' }"
        class="transition hover:text-secondary p-4"
        :class="activeWorks"
        >work</router-link
      >
      <router-link
        :to="{ name: 'contact' }"
        class="transition hover:text-secondary p-4"
        :class="activeContact"
        >contact</router-link
      >
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      visibleLinks: false,
    };
  },

  computed: {
    activeContact() {
      return { "border-b-2 border-white": this.$route.name == "contact" };
    }, //end of activeContacts

    activeWorks() {
      return { "border-b-2 border-white": this.$route.name == "works" };
    }, //end of activeWork

    activeBlogs() {
      return { "border-b-2 border-white": this.$route.name == "blogs" };
    }, //end of activeBlogs

    activeAbout() {
      return { "border-b-2 border-white": this.$route.name == "about" };
    }, //end of activeAbout
  },
};
</script>