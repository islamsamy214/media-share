<template>
  <div class="contain-section w-full p-4 mx-auto rounded-lg">
    <div>
      <table
        class="w-full table-auto shadow"
        v-if="
          !isEmpty &&
          user.permissions.some(
            (permission) => permission.name == 'read_messages'
          )
        "
      >
        <thead>
          <tr class="text-left border-b border-black">
            <th>from</th>
            <th>email</th>
            <th>subject</th>
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
            v-for="(message, index) in messages"
            :key="index"
            :class="{ 'bg-black': !message.read }"
          >
            <td>
              {{ message.sender_name }}
            </td>
            <td>{{ message.email }}</td>
            <td>{{ message.subject.substring(0, 100) }}...</td>
            <td class="text-center">
              <div class="dropdown inline-block relative">
                <router-link
                  class="
                    flex
                    items-center
                    transition
                    bg-primary
                    text-white
                    hover:bg-blue-600
                    py-2
                    px-4
                    whitespace-no-wrap
                    rounded
                  "
                  v-if="
                    user.permissions.some(
                      (permission) => permission.name == 'read_messages'
                    )
                  "
                  :to="{
                    name: 'admin.messages.show',
                    query: {
                      slug: message.slug,
                      id: message.id,
                    },
                    params: {
                      slug: message.slug,
                      id: message.id,
                    },
                  }"
                >
                  <icon icon="ant-design:eye-filled" class="h-4 w-4 mr-2" />
                  show</router-link
                >
              </div>
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
  props: ["messages", "isEmpty", "currentPage", "firstPage", "lastPage"],
  emits: ["previuosPage", "nextPage", "reloadMessages"],

  computed: {
    disablePreviousPage() {
      return { hidden: this.firstPage == this.currentPage };
    },
    disableNextPage() {
      return { hidden: this.lastPage == this.currentPage };
    },

    ...mapGetters({
      user: "admin/getUser",
    }),
  }, //end of disableNextPage
};
</script>