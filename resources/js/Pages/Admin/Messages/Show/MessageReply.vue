<template>
<loading v-if="loading"></loading>
  <div class="shadow mt-24 pb-14 px-2">
    <form @submit.prevent="submitReply" ref="replyForm">
      <div class="h-64">
        <textarea
          class="form-input min-h-full"
          name="content"
          id="content"
          placeholder="write your words"
          v-model="form.content"
        ></textarea>
        <small
          class="errors text-secondary"
          v-if="form.errors && form.errors.content"
        >
          {{ form.errors.content[0] }}
        </small>
      </div>

      <div class="float-right">
        <button class="btn">
          <icon
            icon="akar-icons:arrow-back-thick-fill"
            class="inline mr-2 text-blue-600"
          />
          reply
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: ["messageId", "messageSubject", "email", "senderName"],
  emits: ["reloadMessage"],

  data() {
    return {
      loading: false,
      form: {
        content: "",
        subject: this.messageSubject,
        email: this.email,
        sender_name: this.senderName,
        errors: null,
      },
    };
  }, //end of data

  methods: {
    generateFormData() {
      let formData = new FormData();
      for (let key in this.form) {
        if (typeof this.form[key] != "array") {
          formData.append(key, this.form[key]);
        }
      }
      formData.append("message_id", this.messageId);

      return formData;
    }, //end of generateFormData

    submitReply() {
      this.form.errors = null;
      this.loading = true;
      axios
        .post("/api/admin/messages", this.generateFormData())
        .then((response) => {
          this.$emit("reloadMessage");
          this.$refs.replyForm.reset();
          //flash message
          this.$store.dispatch("flashMessage", {
            message: response.data,
          });
        })
        .catch((error) => {
          this.form.errors = error.response.data.errors;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
};
</script>