<template>
  <div class="w-screen h-screen pl-3">
    <div class="w-full h-full flex justify-center items-center">
      <div
        class="overlay absolute top-0 left-0 w-full h-full"
        @click="$router.back()"
      ></div>
      <div class="absolute flex flex-col z-10 bg-primary rounded-xl p-3">
        <div class="flex flex-col md:flex-row my-2">
          <div class="mx-auto md:mx-2 p-4">
            <img
              :src="user.image_path"
              :alt="user.name"
              class="w-64 h-64 rounded-full"
            />
          </div>
          <div class="flex flex-col py-5">
            <div class="bg-black m-2 p-4 rounded-xl">{{ user.name }}</div>
            <div class="bg-black m-2 p-4 rounded-xl">{{ user.title }}</div>
            <div class="bg-black m-2 p-4 rounded-xl">
              speaks:
              <span v-for="lang in user.languages" :key="lang.id">{{
                lang.language + ", "
              }}</span>
            </div>
            <div class="bg-black m-2 p-4 rounded-xl">
              worked on: {{ user.works_count }} projects, and wrote:
              {{ user.blogs_count }} blogs
            </div>
            <user-links
              :facebook_id="user.facebook_id"
              :linkedin_id="user.linkedin_id"
              :twitter_id="user.twitter_id"
              :behance_id="user.behance_id"
              :instagram_id="user.instagram_id"
              :github_id="user.github_id"
              :youtube_id="user.youtube_id"
            ></user-links>
            <div class="flex flex-row gab-4 justify-center">
              <a
                class="btn"
                :download="user.cv"
                :href="user.cv_path"
                v-if="user.cv"
                >preview cv</a
              >
              <a :href="`mailto:${user.email}`" class="btn">contact</a>
            </div>
          </div>
        </div>
        <user-info
          :about="user.about"
          :education="user.education"
          :skills="user.skills"
          :country="user.country"
          :city="user.city"
        ></user-info>
        <div class="flex justify-end">
          <button class="btn" @click="$router.back()">close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import UserLinks from "./UserLinks.vue";
import UserInfo from "./UserInfo.vue";

export default {
  components: {
    UserLinks,
    UserInfo,
  },

  data() {
    return {
      user: null,
    };
  }, //end of data

  beforeCreate() {
    if (this.$route.params.user == undefined) {
      this.$router.push({ name: "about" });
    }
  }, //end of beforeCreate

  created() {
    this.user = JSON.parse(this.$route.params.user);
  }, //end of created
};
</script>