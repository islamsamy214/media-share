<template>
  <loading v-if="loading"></loading>
  <form @submit.prevent="submitWork" class="grid grid-cols-1 gap-4">
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

    <div class="h-auto mb-8">
      <label for="title">
        <span>description</span>
      </label>
      <textarea
        class="form-input min-h-full"
        name="description"
        id="description"
        placeholder="write your words"
        v-model="form.description"
      ></textarea>
      <small
        class="errors text-secondary"
        v-if="form.errors && form.errors.description"
      >
        {{ form.errors.description[0] }}
      </small>
    </div>

    <div>
      <label for="link">
        <span>link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="link"
        id="link"
        placeholder="https://www.example.com/example"
        v-model="form.link"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.link"
      >
        {{ form.errors.link[0] }}
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

    <div>
      <label for="work_date">
        <span>work date</span>
      </label>
      <input
        class="form-input pt-2.5"
        type="date"
        name="work_date"
        id="work_date"
        v-model="form.work_date"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.work_date"
      >
        {{ form.errors.work_date[0] }}
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
  props: ["work", "workCategories"],

  data() {
    return {
      loading: false,
      categoryVisible: false,
      categories: [],
      form: {
        title: this.work.title,
        image: "",
        description: this.work.description,
        link: this.getLink(),
        categories: this.work.categories,
        work_date: this.work.work_date,
        errors: null,
      },
    };
  }, //end of data

  computed: {
    ...mapGetters({ user: "admin/getUser" }),
  }, //end of computed

  methods: {
    getLink() {
      if (this.work.link) {
        return this.work.link;
      }
      return "";
    }, //end of getLink

    searchCategories(event) {
      let input = event.target.value;
      let categories = this.categories.filter(
        (category) => category.name.indexOf(input) >= 0
      );
      this.categories = categories;
      this.categoryVisible = true;
    }, //end of searchcategorys

    toggleCategories() {
      this.categories = this.workCategories;
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
      formData.append("_method", "PUT");
      return formData;
    }, //end of generateFormData

    submitWork() {
      this.form.errors = null;
      this.loading = true;
      axios
        .post(`/api/admin/works/${this.$route.query.id}`, this.generateFormData())
        .then((response) => {
          this.$router.push({ name: "admin.works" });
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
  }, //end of methodss
};
</script>