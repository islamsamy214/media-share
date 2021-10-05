<template>
<loading v-if="loading"></loading>
  <div class="flex justify-center items-center shadow-lg mt-10">
    <div class="contain bg-primary rounded w-96">
      <div class="m-12">
        <h1 class="text-6xl text-center">register</h1>
      </div>
      <div class="flex justify-center">
        <form class="flex flex-col rounded p-7" @submit.prevent="register">
          <label class="font-semibold text-xs" for="name"> name</label>
          <input
            id="name"
            class="form-input"
            name="name"
            type="text"
            v-model="form.name"
          />
          <small
            class="errors text-secondary mt-4"
            v-if="form.errors && form.errors.name"
          >
            {{ form.errors.name[0] }}
          </small>
          <label class="font-semibold text-xs" for="eamil"> email</label>
          <input
            id="eamil"
            class="form-input"
            name="email"
            type="email"
            v-model="form.email"
          />
          <small
            class="errors text-secondary mt-4"
            v-if="form.errors && form.errors.email"
          >
            {{ form.errors.email[0] }}
          </small>
          <label class="font-semibold text-xs mt-3" for="password"
            >password</label
          >
          <input
            id="password"
            class="form-input"
            type="password"
            v-model="form.password"
          />
          <small
            class="errors text-secondary mt-4"
            v-if="form.errors && form.errors.password"
          >
            {{ form.errors.password[0] }}
          </small>
          <label class="font-semibold text-xs mt-3" for="password_confirmation"
            >confirm password</label
          >
          <input
            id="password_confirmation"
            class="form-input"
            type="password"
            v-model="form.password_confirmation"
          />
          <small
            class="errors text-secondary mt-4"
            v-if="form.errors && form.errors.password"
          >
            {{ form.errors.password[0] }}
          </small>

          <button
            class="
              transition
              flex
              items-center
              justify-center
              h-12
              px-6
              w-full
              bg-primary
              mt-8
              rounded
              font-semibold
              text-sm text-blue-100
              hover:bg-secondary
              shadow
              disabled:opacity-50
            "
            :disabled="loading"
          >
            register
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      form: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
        progress: false,
        errors: null,
      },
    };
  }, //end of data

  methods: {
    register() {
      this.loading = true;
      this.form.errors = null;
      axios
        .post("/register", this.form)
        .then((response) => {
          if (response.status == 200) {
            this.$router.push({ name: "admin.login" });
          }
        })
        .catch((error) => {
          this.form.errors = error.response.data.errors;
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of login
  }, //end of methods

  async beforeRouteEnter(to, from, next) {
    try {
      let user = (await axios.get("/user")).data;
      next({ name: "admin.dashboard" });
    } catch (error) {
      if (error.response.status == 401) {
        next();
      }
    }
  },
};
</script>