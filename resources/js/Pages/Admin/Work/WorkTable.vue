<template>
  <div class="w-full p-4 mx-auto rounded-lg">
    <div
      v-if="
        !isEmpty &&
        user.permissions.some((permission) => permission.name == 'read_works')
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
          v-for="work in works"
          :key="work.id"
        >
          <div
            class="rounded-t-xl relative h-72 cursor-pointer"
            @click="showWork(work)"
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
              :src="work.image_path"
              :alt="work.slug"
            />
          </div>
          <div
            class="
              bg-black
              rounded-b-xl
              h-full
              flex flex-col
              md:flex-row
              items-center
              text-center
              md:text-left
            "
          >
            <div class="p-3 w-7/12">
              <h1 class="font-bold mb-1">{{ work.title }}</h1>
            </div>
            <div class="w-2/5">
              <button
                class="
                  btn
                  bg-primary
                  flex
                  items-center
                  float-right
                  xl:w-9/12
                  mx-auto
                "
                @click="showWork(work)"
              >
                <icon icon="bx:bxs-show" class="inline mx-2" />
                <span>show</span>
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
  props: ["works", "isEmpty", "currentPage", "firstPage", "lastPage"],
  emits: ["previuosPage", "nextPage",],

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
    showWork(work) {
      this.$router.push({
        name: "admin.works.show",
        params: { slug: work.slug, id: work.id },
      });
    }, //end of show work
  }, //end of methods
};
</script>

<style scoped>
.dropdown:hover > .dropdown-content {
  display: block;
  z-index: 10;
}
</style>