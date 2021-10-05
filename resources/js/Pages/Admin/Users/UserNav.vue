<template>
  <div class="flex flex-col sm:flex-row justify-between items-center">
    <span class="p-3 rounded-full bg-black text-sm shadow m-4">
      total: {{ total }}
    </span>
    <form
      @submit.prevent="$emit('submitSearch', search)"
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
        :to="{ name: 'admin.users.create' }"
        v-if="
          user.permissions.some(
            (permission) => permission.name == 'create_users'
          )
        "
      >
        <icon icon="ant-design:user-add-outlined" class="h-4 w-4 inline" />
        add user
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["total"],
  emits: ["submitSearch"],

  data() {
    return {
      search: null,
    };
  }, //end of data

  computed: {
    ...mapGetters({ user: "admin/getUser" }),
  },
};
</script>