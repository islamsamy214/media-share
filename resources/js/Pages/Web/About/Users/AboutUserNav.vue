<template>
  <div class="flex flex-col justify-center">
    <form
      @submit.prevent="$emit('submitSearch', search)"
      class="m-4 flex justify-center items-center"
    >
      <div class="flex items-center">
        <icon icon="bx:bx-search" class="h-6 w-6 inline" />
        <input
          type="text"
          class="
            transition
            rounded-full
            bg-primary
            shadow
            mx-2
            border-none
            focus:ring-2 focus:ring-secondary
          "
          v-model="search"
          placeholder="graphic, web.."
        />
      </div>
      <button class="btn">search</button>
    </form>
  </div>
</template>

<script>
export default {
  emits: ["submitSearch"],

  data() {
    return {
      search: null,
    };
  }, //end of data
};
</script>