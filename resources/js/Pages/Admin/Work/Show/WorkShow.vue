<template>
  <loading v-if="loading"></loading>
  <div class="flex flex-col md:flex-row" v-else>
    <div class="w-full md:w-7/12 self-center">
      <img
        :src="work.image_path"
        :alt="work.image"
        class="md:rounded-tl-xl md:rounded-bl-xl"
      />
    </div>
    <div
      class="
        transition
        transform
        md:-translate-x-3
        w-full
        md:w-1/2
        bg-primary
        p-14
        rounded-xl
        relative
      "
    >
      <div class="my-5">
        <h1 class="text-lg font-bold">{{ work.title }}</h1>
      </div>
      <div class="contain-section my-10 max-h-96">
        <p>{{ work.description }}</p>
      </div>
      <div class="flex flex-col">
        <div class="my-1">
          <div class="text-black">this work made by:</div>
          <div>{{ work.user.name }}</div>
        </div>
        <div class="my-1">
          <div class="text-black">in:</div>
          <div>{{ formattedDate }}</div>
        </div>
        <div class="my-1" v-if="work.link">
          <div class="text-black">live preview:</div>
          <div>
            <a
              :href="work.link"
              target="_blank"
              class="transition hover:text-secondary"
              >click to show</a
            >
          </div>
        </div>
        <div class="my-1">
          <div class="text-black">it belongs to:</div>
          <div v-for="category in work.categories" :key="category.id">
            {{ category.name }} - 
          </div>
        </div>
      </div>
      <div class="mt-5 md:absolute bottom-0 right-0">
        <button class="btn" @click="this.$router.back()">
          <icon icon="eva:arrow-ios-back-fill" class="inline mr-2" />
          back
        </button>
        <button class="btn" @click="shareWork">
          <icon
            icon="akar-icons:arrow-back-thick-fill"
            class="inline mr-2 text-blue-600"
          />
          share
        </button>
        <router-link
          class="btn"
          :to="{
            name: 'admin.works.edit',
            params: { slug: work.slug, id: work.id },
          }"
        >
          <icon icon="akar-icons:edit" class="inline mr-2 text-secondary" />
          edit
        </router-link>
        <button class="btn" @click="askDeleteWork(work.id)">
          <icon icon="bi:trash-fill" class="inline mr-2 text-red-600" />
          delete
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      loading: true,
      work: null,
      intendedIdToDelete: null,
    };
  }, //end of data

  computed: {
    ...mapGetters({
      answer: "getConfirmAnswer",
      user: "admin/getUser",
    }), //end of mapGetters

    formattedDate() {
      let date = new Date(this.work.work_date);
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
        date.getDay() +
        1 +
        " " +
        months[date.getMonth()] +
        " " +
        date.getFullYear();
      return formattedDate;
    }, //end of formattedDate
  }, //end of computed

  watch: {
    answer(gotAnswer) {
      if (gotAnswer == "yes") {
        this.deleteWork();
      }
    }, //end of answer
  }, //end of watch

  methods: {
    shareWork() {
      console.log("share");
    }, //end of share work

    askDeleteWork(workId) {
      this.intendedIdToDelete = workId;
      this.$store.dispatch("askConfirmMessage", {
        message: "do you really want to delete this work?",
      });
    }, //end of askDeleteWork

    deleteWork() {
      this.loading = true;
      axios
        .delete(`/api/admin/works/${this.intendedIdToDelete}`)
        .then((response) => {
          this.$router.push({ name: "admin.works" });
          //flash message
          this.$store.dispatch("flashMessage", {
            message: response.data,
          });
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of deleteWork
  }, //end of methods

  created() {
    axios
      .get(`/api/admin/works/${this.$route.params.id}`)
      .then((response) => {
        this.work = response.data;
      })
      .then(() => {
        this.loading = false;
      });
  }, //end of created

  beforeCreate() {
    if (this.$route.params.id == undefined) {
      this.$router.push({ name: "admin.works" });
    }
  }, //end of beforeCreate
};
</script>