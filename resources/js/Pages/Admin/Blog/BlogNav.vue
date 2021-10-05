<template>
  <div class="flex flex-col sm:flex-row justify-between items-center">
    <span class="p-3 rounded-full bg-black text-sm shadow m-4">
      total: {{ total }}
    </span>
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
    <div class="inline m-4">
      <router-link
        class="btn"
        :to="{ name: 'admin.blogs.create' }"
        v-if="
          user.permissions.some(
            (permission) => permission.name == 'create_blogs'
          )
        "
      >
        <icon icon="si-glyph:typewriter" class="h-4 w-4 inline" />
        add blog
      </router-link>
    </div>
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
  props: ["total", "blogCategories"],
  emits: ["submitSearch"],

  data() {
    return {
      search: "",
      searchCategories: [],
    };
  }, //end of data

  computed: {
    ...mapGetters({ user: "admin/getUser" }),
  }, //end of computed

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