<template>
  <div class="flex flex-col md:flex-row gap-6 my-5 w-full">
    <router-link
      class="
      transition
        flex
        justify-between
        w-full
        items-center
        bg-black
        p-5
        rounded-xl
        hover:bg-secondary
      "
      :to="{ name: 'admin.blogs' }"
    >
      <div class="w-1/2 flex items-center justify-center">
        <icon icon="bx:bxl-blogger" class="w-1/2 h-1/2 inline mb-1 mr-3" />
      </div>
      <div class="w-1/2">
        <span class="w-full h-full text-5xl flex items-center justify-center p-5">
          {{ cards.blogsCount }}
        </span>
      </div>
    </router-link>
    <router-link
      class="
      transition
        flex
        justify-between
        w-full
        items-center
        bg-black
        p-5
        rounded-xl
        hover:bg-secondary
      "
      :to="{ name: 'admin.works' }"
    >
      <div class="w-1/2 flex items-center justify-center">
        <icon icon="dashicons:laptop" class="w-1/2 h-1/2 inline mb-1 mr-3" />
      </div>
      <div class="w-1/2">
        <span class="w-full h-full text-5xl flex items-center justify-center p-5">
          {{ cards.worksCount }}
        </span>
      </div>
    </router-link>
    <router-link
      class="
      transition
        flex
        justify-between
        w-full
        items-center
        bg-black
        p-5
        rounded-xl
        hover:bg-secondary
      "
      :to="{ name: 'admin.messages' }"
    >
      <div class="w-1/2 flex items-center justify-center">
        <icon
          icon="simple-icons:googlemessages"
          class="w-1/2 h-1/2 inline mb-1 mr-3"
        />
      </div>
      <div class="w-1/2">
        <span class="w-full h-full text-5xl flex items-center justify-center p-5">
          {{ cards.messagesCount }}
        </span>
      </div>
    </router-link>
    <div
      class="
      transition
        flex
        justify-between
        w-full
        items-center
        bg-black
        p-5
        rounded-xl
        hover:bg-secondary
      "
    >
      <div class="w-1/2 flex items-center justify-center">
        <icon icon="bi:eye-fill" class="w-1/2 h-1/2 inline mb-1 mr-3" />
      </div>
      <div class="w-1/2">
        <span class="w-full h-full text-5xl flex items-center justify-center p-5">
          {{ cards.visitsCount }}
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["cards"],
};
</script>