<template>
  <loading v-if="loading"></loading>
  <form
    @submit.prevent="submitUser"
    class="grid grid-cols-1 md:grid-cols-2 gap-4"
  >
    <div>
      <label for="name">
        <span>name</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="name"
        id="name"
        placeholder="Jane Doe"
        v-model="form.name"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.name"
      >
        {{ form.errors.name[0] }}
      </small>
    </div>
    <div>
      <label for="title">
        <span>title</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="title"
        id="title"
        placeholder="Graphic Designer"
        v-model="form.title"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.title"
      >
        {{ form.errors.title[0] }}
      </small>
    </div>
    <div class="md:col-span-2">
      <label for="email">
        <span>email</span>
      </label>
      <input
        class="form-input"
        type="email"
        name="email"
        id="email"
        placeholder="example@exam.com"
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
      <label for="password">
        <span>password</span>
      </label>
      <input
        class="form-input"
        type="password"
        name="password"
        id="password"
        v-model="form.password"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.password"
      >
        {{ form.errors.password[0] }}
      </small>
    </div>
    <div>
      <label for="password_confirmation">
        <span>password confirmation</span>
      </label>
      <input
        class="form-input"
        type="password"
        name="password_confirmation"
        id="password"
        v-model="form.password_confirmation"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.password_confirmation"
      >
        {{ form.errors.password_confirmation[0] }}
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
        placeholder="upload image"
        @change="uploadImage"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.image"
      >
        {{ form.errors.image[0] }}
      </small>
    </div>
    <div>
      <label for="cv">
        <span>cv</span>
      </label>
      <input
        class="form-input pt-2.5"
        type="file"
        name="cv"
        id="cv"
        placeholder="upload your cv document"
        @change="uploadCv"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.cv"
      >
        {{ form.errors.cv[0] }}
      </small>
    </div>
    <div>
      <label for="country">
        <span>country</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="country"
        id="country"
        placeholder="egypt"
        v-model="form.country"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.country"
      >
        {{ form.errors.country[0] }}
      </small>
    </div>
    <div>
      <label for="city">
        <span>city</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="city"
        id="city"
        placeholder="cairo"
        v-model="form.city"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.city"
      >
        {{ form.errors.city[0] }}
      </small>
    </div>
    <div class="md:col-span-2">
      <label for="about">
        <span>about</span>
      </label>
      <textarea
        class="form-input"
        name="about"
        id="about"
        placeholder="write a short brief about you"
        v-model="form.about"
      ></textarea>
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.about"
      >
        {{ form.errors.about[0] }}
      </small>
    </div>
    <div class="md:col-span-2">
      <label for="education">
        <span>education</span>
      </label>
      <textarea
        class="form-input"
        name="education"
        id="education"
        placeholder="write a short brief about your education journey"
        v-model="form.education"
      ></textarea>
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.education"
      >
        {{ form.errors.education[0] }}
      </small>
    </div>
    <div class="md:col-span-2">
      <label for="languages">
        <span>languages</span>
      </label>
      <div class="my-4">
        <span
          class="p-2 my-2 mr-2 rounded-full text-sm text-primary bg-secondary"
          v-for="lang in form.languages"
          :key="lang"
        >
          {{ lang }}
          <button class="align-middle" @click="removeChoosedLanguage(lang)">
            <icon icon="ci:off-close" class="inline w-4 h-4" />
          </button>
        </span>
      </div>
      <input
        class="form-input"
        name="languages"
        id="languages"
        placeholder="Choose some languages"
        @click="toggleLanguages"
        @input="searchLanguages"
      />
      <div
        class="mt-1 bg-white text-primary rounded max-h-36 overflow-auto"
        v-if="languageVisible"
      >
        <div
          class="cursor-pointer p-3 rounded hover:bg-secondary"
          v-for="lang in languages"
          :key="lang.key"
          @click="chooseLanguage(lang.key)"
        >
          {{ lang.name }}
        </div>
      </div>
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.languages"
      >
        {{ form.errors.languages[0] }}
      </small>
    </div>
    <div class="md:col-span-2">
      <label for="skills">
        <span>skills</span>
      </label>
      <div class="my-4">
        <span
          class="p-2 my-2 mr-2 rounded-full text-sm text-primary bg-secondary"
          v-for="(skill, index) in form.skills"
          :key="index"
        >
          {{ skill }}
          <button class="align-middle" @click="removeSkill(skill)">
            <icon icon="ci:off-close" class="inline w-4 h-4" />
          </button>
        </span>
      </div>
      <div class="relative">
        <span
          class="
            transition
            cursor-pointer
            absolute
            top-4
            right-3
            hover:text-secondary
          "
          @click="addSkill"
        >
          <icon icon="akar-icons:circle-plus-fill" class="w-4 h-4" />
        </span>
        <input class="form-input" name="skills" id="skills" ref="skill" />
      </div>
      <small
        >don't forget to add the skills <b><u>one by one</u></b> before
        submitting otherwise it will not be added</small
      >
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.skills"
      >
        {{ form.errors.skills[0] }}
      </small>
    </div>
    <div class="md:col-span-2">links</div>
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
      <label for="behance_id">
        <span>behance link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="behance_id"
        id="behance_id"
        placeholder="https://www.behance.com/example-elpamxe"
        @change="generateLinkId($event, 'behance_id')"
        :value="behanceLink"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.behance_id"
      >
        {{ form.errors.behance_id[0] }}
      </small>
    </div>
    <div>
      <label for="github_id">
        <span>github link</span>
      </label>
      <input
        class="form-input"
        type="text"
        name="github_id"
        id="github_id"
        placeholder="https://www.github.com/example-elpamxe"
        @change="generateLinkId($event, 'github_id')"
        :value="githubLink"
      />
      <small
        class="errors text-secondary mt-4"
        v-if="form.errors && form.errors.github_id"
      >
        {{ form.errors.github_id[0] }}
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
    <div class="md:col-span-full">
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
  props: ["user"],

  data() {
    return {
      loading: false,
      languageVisible: false,
      languages: [],
      models: [
        { value: "users", name: "users" },
        { value: "blog_categories", name: "blog categories" },
        { value: "blogs", name: "blogs" },
        { value: "work_categories", name: "work categories" },
        { value: "works", name: "works" },
        { value: "messages", name: "messages" },
      ],
      permissions: ["create", "read", "update", "delete"],
      activeTab: "users",

      form: {
        name: this.user.name,
        title: this.user.title,
        email: this.user.email,
        password: "",
        password_confirmation: "",
        image: "",
        cv: "",
        about: this.user.about,
        education: this.user.education,
        country: this.user.country,
        city: this.user.city,
        facebook_id: "",
        linkedin_id: "",
        twitter_id: "",
        github_id: "",
        behance_id: "",
        youtube_id: "",
        instagram_id: "",
        languages: [],
        skills: [],
        permissions: [],
        errors: null,
      },
    };
  }, //end of data

  computed: {
    facebookLink() {
      if (this.user.facebook_id) {
        return `https://www.facebook.com/${this.user.facebook_id}`;
      }
    }, //end of facebookLink
    instagramLink() {
      if (this.user.instagram_id) {
        return `https://www.instagram.com/${this.user.instagram_id}`;
      }
    }, //end of instagramLink
    twitterLink() {
      if (this.user.twitter_id) {
        return `https://www.twitter.com/${this.user.twitter_id}`;
      }
    }, //end of twitterLink
    githubLink() {
      if (this.user.github_id) {
        return `https://www.github.com/${this.user.github_id}`;
      }
    }, //end of githubLink
    behanceLink() {
      if (this.user.behance_id) {
        return `https://www.behance.com/${this.user.behance_id}`;
      }
    }, //end of behanceLink
    linkedinLink() {
      if (this.user.linkedin_id) {
        return `https://www.linkedin.com/${this.user.linkedin_id}`;
      }
    }, //end of linkedinLink
    youtubeLink() {
      if (this.user.youtube_id) {
        return `https://www.youtube.com/${this.user.youtube_id}`;
      }
    }, //end of youtubeLink
  }, //end of computed

  methods: {
    searchLanguages(event) {
      let input = event.target.value;
      let languages = this.languages.filter(
        (lang) => lang.name.indexOf(input) > -1
      );
      this.languages = languages;
      this.languageVisible = true;
    }, //end of searchlangs

    toggleLanguages() {
      this.languages = [
        { key: "ar", name: "arabic" },
        { key: "en", name: "english" },
        { key: "es", name: "spanish" },
        { key: "fr", name: "french" },
        { key: "hi", name: "hindi" },
        { key: "id", name: "indonesian" },
        { key: "ja", name: "japanese" },
        { key: "io", name: "laotian" },
        { key: "nds", name: "low german / low saxon" },
        { key: "rmy", name: "romani" },
        { key: "ru", name: "russian" },
        { key: "rw", name: "rwandi" },
        { key: "sr", name: "serbian" },
        { key: "tr", name: "turkish" },
        { key: "zh", name: "chinese" },
      ];
      this.languageVisible = !this.languageVisible;
    }, //end of showlangs

    chooseLanguage(key) {
      if (!this.form.languages.includes(key)) {
        this.form.languages.push(key);
        this.languageVisible = false;
      }
    }, //end of chooselang

    removeChoosedLanguage(key) {
      let languages = this.form.languages.filter((lang) => lang != key);
      this.form.languages = languages;
    }, //end of choosedLang

    addSkill() {
      let skill = this.$refs.skill.value.trim();
      if (!this.form.skills.includes(skill) && skill != "") {
        this.form.skills.push(skill);
        this.$refs.skill.value = "";
      }
    }, //end of addskill

    removeSkill(skill) {
      let skills = this.form.skills.filter((sk) => sk != skill);
      this.form.skills = skills;
    }, //end of choosedLang

    uploadImage(event) {
      this.form.image = event.currentTarget.files[0];
    }, //end of image upload

    uploadCv(event) {
      this.form.cv = event.currentTarget.files[0];
    }, //end of cv upload

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
        if (site_id == "behance_id") {
          this.form.behance_id = dividedLink;
        }
        if (site_id == "github_id") {
          this.form.github_id = dividedLink;
        }
      }
    }, //end of generateLinkId

    addPermission(permission, model) {
      let modelPermission = permission + "_" + model;
      if (this.form.permissions.includes(modelPermission)) {
        //remove the permission if exist
        this.form.permissions = this.form.permissions.filter(
          (perm) => perm != modelPermission
        );
      } else {
        this.form.permissions.push(modelPermission);
      }
    }, //end of addPermission

    generateFormData() {
      let formData = new FormData();
      for (let key in this.form) {
        if (typeof this.form[key] != "array") {
          formData.append(key, this.form[key]);
        }
      }
      if (this.form.languages.length != 0) {
        formData.append("languages", JSON.stringify(this.form.languages));
      }
      if (this.form.skills.length != 0) {
        formData.append("skills", JSON.stringify(this.form.skills));
      }
      if (this.form.permissions.length != 0) {
        formData.append("permissions", JSON.stringify(this.form.permissions));
      }
      formData.append("_method", "PUT");
      return formData;
    }, //end of generateFormData

    submitUser() {
      this.form.errors = null;
      this.loading = true;
      axios
        .post(
          `/api/admin/users/${this.$route.params.id}/profile`,
          this.generateFormData()
        )
        .then((response) => {
          this.$router.push({ name: "admin.users" }).then(() => {
            location.reload();
          });
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
  created() {
    //render the arrays
    this.user.permissions.forEach((permission) =>
      this.form.permissions.push(permission.name)
    );
    this.user.skills.forEach((skill) => this.form.skills.push(skill.skill));
    this.user.languages.forEach((language) =>
      this.form.languages.push(language.language)
    );
  },
};
</script>

<style scoped>
.checkbox:checked {
  color: #fca311;
}
</style>