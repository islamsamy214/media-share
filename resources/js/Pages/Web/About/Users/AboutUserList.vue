<template>
  <router-view class="absolute w-screen h-screen top-21 md:top-10 -left-2 sm:-left-5 z-10"></router-view>
  <div class="flex flex-col lg:flex-row">
    <!-- start of card -->
    <div
      class="w-full lg:w-1/3 my-3 lg:m-3"
      v-for="user in users"
      :key="user.id"
    >
      <div class="w-full flex justify-center relative h-3/4">
        <div
          class="
            overlay
            transition
            absolute
            rounded-xl
            top-0
            left-0
            bg-black
            opacity-50
            w-full
            h-full
            hover:opacity-0
          "
        ></div>
        <img :src="user.image_path" :alt="user.name" class="rounded-xl" />
      </div>
      <span class="block text-center p-2">{{
        user.title + "-" + user.name
      }}</span>
      <div class="flex justify-center">
        <router-link
          :to="{
            name: 'about.users.show',
            params: { slug: user.slug, user: JSON.stringify(user) },
          }"
          class="btn"
        >
          <span>preview</span>
        </router-link>
      </div>
    </div>
    <!-- end of card -->
  </div>
</template>
<script>
export default {
  props: ["users"],
};
</script>