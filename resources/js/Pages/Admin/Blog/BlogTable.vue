<template>
  <div class="w-full p-4 mx-auto rounded-lg">
    <div
      v-if="
        !isEmpty &&
        user.permissions.some((permission) => permission.name == 'read_blogs')
      "
    >
      <div
        class="
          grid grid-cols-1
          md:grid-cols-2
          lg:grid-cols-4
          gap-3
          justify-items-stretch
        "
      >
        <div
          class="flex flex-col rounded-xl shadow mx-auto lg:mx-px"
          v-for="blog in blogs"
          :key="blog.id"
        >
          <div
            class="rounded-t-xl relative h-72 cursor-pointer"
            @click="showBlog(blog)"
          >
            <div
              class="
                overlay
                transition
                absolute
                rounded-t-xl
                top-0
                left-0
                bg-black
                opacity-50
                w-full
                h-full
                hover:opacity-0
              "
            ></div>
            <img
              class="transition rounded-t-xl w-full h-full"
              :src="blog.image_path"
              :alt="blog.slug"
            />
          </div>
          <div class="bg-black rounded-b-xl h-full">
            <div class="p-3 mt-3">
              <h1 class="font-bold mb-1">{{ blog.title }}</h1>
              <p class="text-md opacity-90">
                {{ blog.content.substring(0, 120) }}...
              </p>
            </div>
            <div class="float-right bottom-0 m-3">
              <button class="btn bg-primary" @click="showBlog(blog)">
                <icon icon="cib:read-the-docs" class="inline mx-2" />
                <span>read more</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="paginator m-5">
        <icon
          icon="akar-icons:chevron-left"
          class="h-6 w-6 inline mr-5 cursor-pointer"
          :class="disablePreviousPage"
          @click="$emit('previuosPage')"
        />
        <span class="mr-5">{{ currentPage }}</span>
        <icon
          icon="akar-icons:chevron-right"
          class="h-6 w-6 inline mr-5 cursor-pointer"
          :class="disableNextPage"
          @click="$emit('nextPage')"
        />
      </div>
    </div>
    <div v-else class="text-center">There is no data to show</div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["blogs", "isEmpty", "currentPage", "firstPage", "lastPage"],
  emits: ["previuosPage", "nextPage"],

  computed: {
    disablePreviousPage() {
      return { hidden: this.firstPage == this.currentPage };
    }, //end of disablePrePage
    disableNextPage() {
      return { hidden: this.lastPage == this.currentPage };
    }, //end of disableNextPage

    ...mapGetters({
      user: "admin/getUser",
    }),
  },

  methods: {
    showBlog(blog) {
      this.$router.push({
        name: "admin.blogs.show",
        params: { slug: blog.slug, id: blog.id },
      });
    }, //end of show blog
  }, //end of methods
};
</script>

<style scoped>
.dropdown:hover > .dropdown-content {
  display: block;
  z-index: 10;
}
</style>