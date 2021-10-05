<template>
  <div class="flex flex-col sm:flex-row justify-center items-center">
    <form
      @submit.prevent="$emit('submitSearch', search, searchCategories)"
      class="m-4 flex justify-between items-center"
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
        />
      </div>
      <button class="btn">search</button>
    </form>
  </div>
  <div class="mx-auto text-center">
    <button
      v-for="blogCategory in blogCategories"
      :key="blogCategory"
      class="btn bg-black m-1"
      :class="{
        'ring-2 ring-secondary': searchCategories.includes(blogCategory.id),
      }"
      @mouseover="showCategoryChip($event, blogCategory.name)"
      @mouseleave="hideCategoryChip($event, blogCategory.name)"
      @click="toggleSearchCategory(blogCategory.id)"
    >
      {{ blogCategory.name.substring(0, 10) }}..
    </button>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["blogCategories"],
  emits: ["submitSearch"],

  data() {
    return {
      search: "",
      searchCategories: [],
    };
  }, //end of data

  methods: {
    showCategoryChip(event, blogCategoryName) {
      event.target.innerHTML = blogCategoryName;
    }, //end of showCategoryChip

    hideCategoryChip(event, blogCategoryName) {
      event.target.innerHTML = blogCategoryName.substring(0, 10);
    }, //end of hideCategoryChip

    toggleSearchCategory(blogCategoryId) {
      if (this.searchCategories.includes(blogCategoryId)) {
        this.searchCategories = this.searchCategories.filter(
          (cat) => cat != blogCategoryId
        );
      } else {
        this.searchCategories.push(blogCategoryId);
      }
      this.$emit("submitSearch", this.search, this.searchCategories);
    },
  }, //end of methods
};
</script>