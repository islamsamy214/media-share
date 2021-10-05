<template>
  <loading v-if="loading"></loading>
  <div v-else>
    <div class="md:flex">
      <div class="flex my-2 md:mr-2 p-3 rounded-xl w-full">
        <!-- headers -->
        <div class="w-1/2">
          <div>
            <h2 class="m-1">name</h2>
            <h2 class="m-1">email</h2>
            <h2 class="m-1">sent in</h2>
          </div>
        </div>
        <!-- values -->
        <div class="w-1/2">
          <div class="text-right">
            <h2 class="m-1">{{ message.email }}</h2>
            <h2 class="m-1">{{ message.sender_name }}</h2>
            <h2 class="m-1">{{ formatteDate(message.created_at) }}</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-black p-5 rounded-xl">
      <h1 class="text-lg font-bold mb-7">{{ message.subject }}</h1>
      <p class="text-md m-1">{{ message.content }}</p>
    </div>

    <div class="float-right mt-7">
      <button class="btn" @click="this.$router.back()">
        <icon icon="eva:arrow-ios-back-fill" class="inline mr-2" />
        back
      </button>
      <button class="btn" @click="askDeleteMessage(message.id)">
        <icon icon="bi:trash-fill" class="inline mr-2 text-red-600" />
        delete
      </button>
    </div>

    <message-reply
      :messageId="message.id"
      :messageSubject="message.subject"
      :email="message.email"
      :senderName="message.sender_name"
      @reloadMessage="getMessage"
    ></message-reply>

    <div v-if="message.replies.length != 0">
      <div>replies:</div>
      <div v-for="(reply, index) in message.replies" :key="index" class="my-5">
        <div class="shadow p-4">
          {{ reply.pivot.content }}
        </div>
        <small>
          {{ formatteDate(reply.pivot.created_at) }}
        </small>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import MessageReply from "./MessageReply.vue";

export default {
  components: {
    MessageReply,
  },

  data() {
    return {
      loading: true,
      message: null,
      intendedIdToDelete: null,
    };
  }, //end of data

  computed: {
    ...mapGetters({
      answer: "getConfirmAnswer",
    }), //end of mapGetters
  }, //end of computed

  watch: {
    answer(gotAnswer) {
      if (gotAnswer == "yes") {
        this.deleteMessage();
      }
    }, //end of answer
  }, //end of watch

  methods: {
    getMessage() {
      axios
        .get(`/api/admin/messages/${this.$route.params.id}`)
        .then((response) => {
          this.message = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of getMessage

    formatteDate(unformattedDate) {
      let date = new Date(unformattedDate);
      const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];
      let formattedDate =
        date.getDate() +
        " " +
        months[date.getMonth()] +
        " " +
        date.getFullYear();
      return formattedDate;
    }, //end of formattedDate

    askDeleteMessage(messageId) {
      this.intendedIdToDelete = messageId;
      this.$store.dispatch("askConfirmMessage", {
        message: "do you really want to delete this message?",
      });
    }, //end of askDeleteMessage

    deleteMessage() {
      this.loading = true;
      axios
        .delete(`/api/admin/messages/${this.intendedIdToDelete}`)
        .then((response) => {
          this.$router.push({ name: "admin.messages" });
          //flash message
          this.$store.dispatch("flashMessage", {
            message: response.data,
          });
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of deleteMessage
  }, //end of methods

  created() {
    this.getMessage();
  }, //end of created

  beforeCreate() {
    if (this.$route.params.id == undefined) {
      this.$router.push({ name: "admin.messages" });
    }
  }, //end of beforeCreate
};
</script>