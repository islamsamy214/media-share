<template>
  <loading v-if="loading"></loading>
  <form
    @submit.prevent="submitBlogCategory"
    class="grid grid-cols-1 md:grid-cols-2 gap-4"
  >
    <div class="md:col-span-2">
      <label for="name">
        <span>name</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="name"
        id="name"
        placeholder="Graphic Design"
        v-model="form.name"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.name"
      >
        {{ form.errors.name[0] }}
      </small>
    </div>
    <div class="md:col-span-full">
      <button class="btn float-right" type="submit">submit</button>
    </div>
  </form>
</template>

<script>
export default {
  props: ["blogCategory"],

  data() {
    return {
      loading: false,

      form: {
        name: this.blogCategory.name,
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
      formData.append("_method", "PUT");
      return formData;
    }, //end of generateFormData

    submitBlogCategory() {
      this.form.errors = null;
      this.loading = true;
      axios
        .post(
          `/api/admin/blogcategories/${this.$route.params.id}`,
          this.generateFormData()
        )
        .then((response) => {
          this.$router.push({ name: "admin.blogcategories" });
          //flash message
          this.$store.dispatch("flashMessage", {
            message: "category updated successfully",
          });
        })
        .catch((error) => {
          this.form.errors = error.response.data.errors;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methodss
};
</script>