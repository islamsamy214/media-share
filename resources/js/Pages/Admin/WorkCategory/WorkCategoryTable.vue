<template>
  <loading v-if="loading"></loading>
  <div class="contain-section w-full p-4 mx-auto rounded-lg">
    <div>
      <table
        class="w-full table-auto shadow"
        v-if="
          !isEmpty &&
          user.permissions.some(
            (permission) => permission.name == 'read_work_categories'
          )
        "
      >
        <thead>
          <tr class="text-left border-b border-black">
            <th>name</th>
            <th class="text-center">works</th>
            <th class="text-center">actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            class="
              transition
              hover:bg-black
              hover:scale-50
              border-b border-gray-500 border-opacity-30
            "
            v-for="(workCategory, index) in workCategories"
            :key="index"
          >
            <td>
              {{ workCategory.name }}
            </td>
            <td class="text-center">{{ workCategory.works_count }}</td>
            <td class="text-center">
              <buttons-list>
                <template #title>
                  <icon icon="majesticons:dots-circle-line" class="h-6 w-6" />
                </template>
                <template #>
                  <router-link
                    class="button-list"
                    :to="{
                      name: 'admin.workcategories.edit',
                      query: {
                        slug: workCategory.slug,
                        id: workCategory.id,
                      },
                      params: {
                        slug: workCategory.slug,
                        id: workCategory.id,
                      },
                    }"
                    v-if="
                      user.permissions.some(
                        (permission) =>
                          permission.name == 'update_work_categories'
                      )
                    "
                  >
                    <div class="flex gap-2 items-center">
                      <icon icon="akar-icons:edit" class="inline w-4 h-4" />
                      <span>edit</span>
                    </div>
                  </router-link>
                  <button
                    class="button-list"
                    v-if="
                      user.permissions.some(
                        (permission) =>
                          permission.name == 'delete_work_categories'
                      )
                    "
                    @click="askDeleteWorkCategory(workCategory.id)"
                  >
                    <div class="flex gap-2 items-center">
                      <icon icon="bx:bxs-trash" class="inline w-4 h-4" />
                      <span>delete</span>
                    </div>
                  </button>
                </template>
              </buttons-list>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td class="col-span-full p-4">
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
            </td>
          </tr>
        </tfoot>
      </table>
      <div v-else class="text-center">There is no data to show</div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["workCategories", "isEmpty", "currentPage", "firstPage", "lastPage"],
  emits: ["previuosPage", "nextPage", "reloadWorkCategorys"],

  data() {
    return {
      intendedIdToDelete: null,
      loading: false,
    };
  }, //end of data

  computed: {
    disablePreviousPage() {
      return { hidden: this.firstPage == this.currentPage };
    },
    disableNextPage() {
      return { hidden: this.lastPage == this.currentPage };
    },

    ...mapGetters({
      answer: "getConfirmAnswer",
      user: "admin/getUser",
    }),
  }, //end of disableNextPage

  watch: {
    answer(gotAnswer) {
      if (gotAnswer == "yes") {
        this.deleteWorkCategory();
      }
    },
  },

  methods: {
    askDeleteWorkCategory(workCategoryId) {
      this.intendedIdToDelete = workCategoryId;
      this.$store.dispatch("askConfirmMessage", {
        message: "do you really want to delete this category?",
      });
    },

    deleteWorkCategory() {
      this.loading = true;
      axios
        .delete(`/api/admin/workcategories/${this.intendedIdToDelete}`)
        .then((response) => {
          this.$emit("reloadWorkCategorys");
          //flash message
          this.$store.dispatch("flashMessage", {
            message: "category deleted successfully",
          });
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
};
</script>

<style scoped>
.dropdown:hover > .dropdown-content {
  display: block;
  z-index: 10;
}
</style>