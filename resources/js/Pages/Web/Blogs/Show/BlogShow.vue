<template>
  <loading v-if="loading"></loading>
  <div v-else>
    <div>
      <h1 class="text-lg text-center font-bold mb-1">{{ blog.title }}</h1>
    </div>
    <div
      v-if="blog.image != 'default.jpg'"
      class="max-w-sm my-5 mx-auto shadow"
    >
      <img
        class="transition rounded-xl w-full h-full"
        :src="blog.image_path"
        :alt="blog.slug"
      />
    </div>
    <div>
      <p class="text-md m-1" v-html="reformatBlogContent"></p>
    </div>
    <div v-if="blog.youtube_link">
      <iframe
        class="rounded-xl w-full h-96 my-5 mx-auto"
        :src="blog.youtube_link"
        title="YouTube video player"
        frameborder="0"
        allowfullscreen
      ></iframe>
    </div>
    <div class="shadow p-1">
      <span class="text-gray-300">this blog considered as: </span>
      <span v-for="category in blog.categories" :key="category.id"
        >{{ category.name }},
      </span>
    </div>
    <div class="float-right">
      <button class="btn" @click="this.$router.back()">
        <icon icon="eva:arrow-ios-back-fill" class="inline mr-2" />
        back
      </button>
      <button class="btn" @click="shareBlog">
        <icon
          icon="akar-icons:arrow-back-thick-fill"
          class="inline mr-2 text-blue-600"
        />
        share
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: true,
      blog: null,
    };
  }, //end of data

  computed: {
    reformatBlogContent() {
      let content = this.blog.content;
      //modify headers
      let headers = [...this.blog.content.matchAll(/\#(.*?)\#/g)];
      if (headers) {
        headers.forEach((header) => {
          content = content.replaceAll(
            header[0],
            `<h1 class="text-lg font-bold">${header[1]}</h1>`
          );
        });
      }
      //modify snaps
      let snaps = [...this.blog.content.matchAll(/\`(.*?)\`/g)];
      if (snaps) {
        snaps.forEach((snap) => {
          content = content.replaceAll(
            snap[0],
            `<span class="bg-black p-1 m-1 rounded">${snap[1]}</span>`
          );
        });
      }
      //modify ocdes
      let codes = [...this.blog.content.matchAll(/!([^!]+)!/g)];
      if (codes) {
        codes.forEach((code) => {
          code[1] = code[1].replaceAll("<", "&lt;").replaceAll(">", "&gt;");
          content = content.replaceAll(
            code[0],
            `<pre><div class="contain-section bg-black p-2 my-2 rounded">${code[1]}</div></pre>`
          );
        });
      }
      return content;
    }, //end of reformatBlogContent
  }, //end of computed

  methods: {
    shareBlog() {
      navigator.clipboard.writeText(location.href);
      this.$store.dispatch("flashMessage", {
        message: "URL copied to clipboard",
      });
    }, //end of share blog
  }, //end of methods

  created() {
    axios
      .get(`/api/blogs/${this.$route.query.id}`)
      .then((response) => {
        this.blog = response.data;
      })
      .then(() => {
        this.loading = false;
      });
  }, //end of created

  beforeCreate() {
    if (this.$route.query.id == undefined) {
      this.$router.push({ name: "blogs" });
    }
  }, //end of beforeCreate
};
</script>