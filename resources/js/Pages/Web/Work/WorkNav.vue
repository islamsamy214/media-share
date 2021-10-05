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
      v-for="workCategory in workCategories"
      :key="workCategory"
      class="btn bg-black m-1"
      :class="{
        'ring-2 ring-secondary': searchCategories.includes(workCategory.id),
      }"
      @mouseover="showCategoryChip($event, workCategory.name)"
      @mouseleave="hideCategoryChip($event, workCategory.name)"
      @click="toggleSearchCategory(workCategory.id)"
    >
      {{ workCategory.name.substring(0, 10) }}..
    </button>
  </div>
</template>

<script>
export default {
  props: ["workCategories"],
  emits: ["submitSearch"],

  data() {
    return {
      search: "",
      searchCategories: [],
    };
  }, //end of data

  methods: {
    showCategoryChip(event, workCategoryName) {
      event.target.innerHTML = workCategoryName;
    }, //end of showCategoryChip

    hideCategoryChip(event, workCategoryName) {
      event.target.innerHTML = workCategoryName.substring(0, 10);
    }, //end of hideCategoryChip

    toggleSearchCategory(workCategoryId) {
      if (this.searchCategories.includes(workCategoryId)) {
        this.searchCategories = this.searchCategories.filter(
          (cat) => cat != workCategoryId
        );
      } else {
        this.searchCategories.push(workCategoryId);
      }
      this.$emit("submitSearch", this.search, this.searchCategories);
    },
  }, //end of methods
};
</script>