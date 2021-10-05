<template>
  <loading v-if="loading"></loading>
  <form
    class="grid grid-cols-1 gap-4 p-4 bg-black rounded-xl"
    @submit.prevent="submitMessage"
    v-else
  >
    <div>
      <label for="name">
        <span>name</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="sender_name"
        id="name"
        placeholder="John wick"
        v-model="form.sender_name"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.sender_name"
      >
        {{ form.errors.sender_name[0] }}
      </small>
    </div>

    <div>
      <label for="email">
        <span>email</span>
      </label>
      <input
        class="form-input"
        type="email"
        name="email"
        id="email"
        placeholder="JohnWick@pencil.com"
        v-model="form.email"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.email"
      >
        {{ form.errors.email[0] }}
      </small>
    </div>

    <div>
      <label for="subject">
        <span>subject</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="subject"
        id="subject"
        placeholder="Hello there i'm a serial killer,Thank you"
        v-model="form.subject"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.subject"
      >
        {{ form.errors.subject[0] }}
      </small>
    </div>

    <div class="h-64 mb-8">
      <label for="message">
        <span>message</span>
      </label>
      <textarea
        class="form-input min-h-full"
        name="content"
        placeholder="i made three movies to protect my dog"
        v-model="form.content"
      ></textarea>
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.content"
      >
        {{ form.errors.content[0] }}
      </small>
    </div>

    <div>
      <button class="btn float-right bg-primary" type="submit">submit</button>
    </div>
  </form>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      form: {
        sender_name: "",
        email: "",
        subject: "",
        content: "",
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
      return formData;
    }, //end of generateFormData

    submitMessage(event) {
      this.form.errors = null;
      this.loading = true;
      axios
        .post(`/api/message`, this.generateFormData())
        .then((response) => {
          //reset form
          for (let key in this.form) {
            this.form[key] = "";
          }
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
    }, //end of sumbotmessage
  }, //end of mehtods
};
</script>