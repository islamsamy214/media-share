<template>
  <loading v-if="loading"></loading>
  <form @submit.prevent="submitBlog" class="grid grid-cols-1 gap-4">
    <div>
      <label for="title">
        <span>title</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="title"
        id="title"
        placeholder="how to be creative"
        v-model="form.title"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.title"
      >
        {{ form.errors.title[0] }}
      </small>
    </div>

    <div>
      <label for="image">
        <span>image</span>
      </label>
      <input
        class="form-input pt-2.5"
        type="file"
        name="image"
        id="image"
        @change="uploadImage"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.image"
      >
        {{ form.errors.image[0] }}
      </small>
    </div>

    <div class="h-64 mb-28">
      <label for="title">
        <span>content</span>
      </label>
      <textarea
        class="form-input min-h-full"
        name="content"
        id="content"
        placeholder="write your words"
        v-model="form.content"
      ></textarea>
      <small class="flex flex-col mt-4">
        <span>
          when you want to add a header use ## like this
          <strong>#header#</strong>
        </span>
        <span>
          when you want to add an linear snap use `` like this
          <strong>`strong`</strong>
        </span>
        <span>
          when you want to add an block snap use !! like this
          <strong>``strong block``</strong>
        </span>
      </small>

      <small
        class="errors text-secondary"
        v-if="form.errors && form.errors.content"
      >
        {{ form.errors.content[0] }}
      </small>
    </div>

    <div>
      <label for="youtube_link">
        <span>youtube link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="youtube_link"
        id="youtube_link"
        placeholder="https://www.youtube.com/example"
        v-model="form.youtube_link"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.youtube_link"
      >
        {{ form.errors.youtube_link[0] }}
      </small>
    </div>

    <div>
      <label for="categories">
        <span>categories</span>
      </label>
      <div class="my-4">
        <span
          class="p-2 my-4 mr-2 rounded-full text-sm text-primary bg-secondary"
          v-for="category in form.categories"
          :key="category.id"
        >
          {{ category.name }}
          <button
            class="align-middle"
            @click="removeChoosedCategory(category.id)"
          >
            <icon icon="akar-icons:circle-x-fill" class="h-4 w-4" />
          </button>
        </span>
      </div>
      <input
        class="form-input"
        name="categories"
        id="categories"
        placeholder="Choose some categories"
        @click="toggleCategories"
        @input="searchCategories"
      />
      <div
        class="mt-1 bg-white text-primary rounded max-h-36 overflow-auto"
        v-if="categoryVisible"
      >
        <div
          class="cursor-pointer p-3 rounded hover:bg-secondary"
          v-for="category in categories"
          :key="category.key"
          @click="chooseCategory(category)"
        >
          {{ category.name }}
        </div>
      </div>
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.categories"
      >
        {{ form.errors.categories[0] }}
      </small>
    </div>

    <div class="md:col-span-full">
      <button class="btn float-right" type="submit">submit</button>
    </div>
  </form>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["blogCategories"],

  data() {
    return {
      loading: false,
      categoryVisible: false,
      categories: [],
      form: {
        title: "",
        image: "",
        content: "",
        youtube_link: "",
        categories: [],
        errors: null,
      },
    };
  }, //end of data

  computed: {
    ...mapGetters({ user: "admin/getUser" }),
  }, //end of computed

  methods: {
    searchCategories(event) {
      let input = event.target.value;
      let categories = this.categories.filter(
        (category) => category.name.indexOf(input) >= 0
      );
      this.categories = categories;
      this.categoryVisible = true;
    }, //end of searchcategorys

    toggleCategories() {
      this.categories = this.blogCategories;
      this.categoryVisible = !this.categoryVisible;
    }, //end of showcategorys

    chooseCategory(category) {
      if (!this.form.categories.includes(category)) {
        this.form.categories.push(category);
        this.categoryVisible = false;
      }
    }, //end of choosecategory

    removeChoosedCategory(id) {
      let categories = this.form.categories.filter(
        (category) => category.id != id
      );
      this.form.categories = categories;
    }, //end of choosedLang

    uploadImage(event) {
      this.form.image = event.currentTarget.files[0];
    }, //end of image upload

    generateFormData() {
      let formData = new FormData();
      for (let key in this.form) {
        if (typeof this.form[key] != "array") {
          formData.append(key, this.form[key]);
        }
      }
      if (this.form.categories.length != 0) {
        formData.append("categories", JSON.stringify(this.form.categories));
      }
      formData.append("user_id", this.user.id);
      return formData;
    }, //end of generateFormData

    submitBlog() {
      this.form.errors = null;
      this.loading = true;
      axios
        .post("/api/admin/blogs", this.generateFormData())
        .then((response) => {
          this.$router.push({ name: "admin.blogs" });
          // //flash message
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