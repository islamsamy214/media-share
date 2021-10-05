<template>
  <loading v-if="loading"></loading>
  <form
    @submit.prevent="submitContact"
    class="grid grid-cols-1 md:grid-cols-2 gap-4"
    v-else
  >
    <div>
      <label for="facebook_id">
        <span>email</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="facebook_id"
        id="facebook_id"
        placeholder="mail.example.com"
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
      <label for="facebook_id">
        <span>facebook link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="facebook_id"
        id="facebook_id"
        placeholder="https://www.facebook.com/example-elpamxe"
        @change="generateLinkId($event, 'facebook_id')"
        :value="facebookLink"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.facebook_id"
      >
        {{ form.errors.facebook_id[0] }}
      </small>
    </div>
    <div>
      <label for="instagram_id">
        <span>instagram link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="instagram_id"
        id="instagram_id"
        placeholder="https://www.insatgram.com/example-elpamxe"
        @change="generateLinkId($event, 'instagram_id')"
        :value="instagramLink"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.instagram_id"
      >
        {{ form.errors.instagram_id[0] }}
      </small>
    </div>
    <div>
      <label for="twitter_id">
        <span>twitter link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="twitter_id"
        id="twitter_id"
        placeholder="https://www.twitter.com/example-elpamxe"
        @change="generateLinkId($event, 'twitter_id')"
        :value="twitterLink"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.twitter_id"
      >
        {{ form.errors.twitter_id[0] }}
      </small>
    </div>
    <div>
      <label for="linkedin_id">
        <span>linkedin link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="linkedin_id"
        id="linkedin_id"
        placeholder="https://www.linkedin.com/example-elpamxe"
        @change="generateLinkId($event, 'linkedin_id')"
        :value="linkedinLink"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.linkedin_id"
      >
        {{ form.errors.linkedin_id[0] }}
      </small>
    </div>
    <div>
      <label for="youtube_id">
        <span>youtube link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="youtube_id"
        id="youtube_id"
        placeholder="https://www.youtube.com/example-elpamxe"
        @change="generateLinkId($event, 'youtube_id')"
        :value="youtubeLink"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.youtube_id"
      >
        {{ form.errors.youtube_id[0] }}
      </small>
    </div>
    <div class="md:col-span-full">
      <button class="btn float-right" type="submit">submit</button>
    </div>
  </form>
</template>

<script>
export default {
  props: ["contact"],

  data() {
    return {
      loading: false,
      form: {
        email: this.contact.email,
        facebook_id: "",
        linkedin_id: "",
        twitter_id: "",
        youtube_id: "",
        instagram_id: "",
        errors: null,
      },
    };
  }, //end of data

  computed: {
    facebookLink() {
      if (this.contact.facebook_id) {
        return `https://www.facebook.com/${this.contact.facebook_id}`;
      }
    }, //end of facebookLink
    instagramLink() {
      if (this.contact.instagram_id) {
        return `https://www.instagram.com/${this.contact.instagram_id}`;
      }
    }, //end of instagramLink
    twitterLink() {
      if (this.contact.twitter_id) {
        return `https://www.twitter.com/${this.contact.twitter_id}`;
      }
    }, //end of twitterLink
    linkedinLink() {
      if (this.contact.linkedin_id) {
        return `https://www.linkedin.com/${this.contact.linkedin_id}`;
      }
    }, //end of linkedinLink
    youtubeLink() {
      if (this.contact.youtube_id) {
        return `https://www.youtube.com/${this.contact.youtube_id}`;
      }
    }, //end of youtubeLink
  }, //end of computed

  methods: {
    generateLinkId(event, site_id) {
      let link = event.target.value;
      let dividedLink = link.split("/")[3];
      if (dividedLink != undefined) {
        if (site_id == "facebook_id") {
          this.form.facebook_id = dividedLink;
        }
        if (site_id == "linkedin_id") {
          this.form.linkedin_id = dividedLink;
        }
        if (site_id == "twitter_id") {
          this.form.twitter_id = dividedLink;
        }
        if (site_id == "youtube_id") {
          this.form.youtube_id = dividedLink;
        }
        if (site_id == "instagram_id") {
          this.form.instagram_id = dividedLink;
        }
      }
    }, //end of generateLinkId

    generateFormData() {
      let formData = new FormData();
      for (let key in this.form) {
        if (typeof this.form[key] != "array") {
          formData.append(key, this.form[key]);
        }
      }
      formData.append("_method", "PUT");
      return formData;
    }, //end of generateFormData

    submitContact() {
      this.form.errors = null;
      this.loading = true;
      axios
        .post(`/api/admin/contacts/${1}`, this.generateFormData())
        .then((response) => {
          this.$router.push({ name: "admin.messages" });
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
    }, //end of submitContact
  }, //end of methods
};
</script>