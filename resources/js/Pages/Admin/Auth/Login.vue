<template>
<loading v-if="loading"></loading>
  <div class="flex justify-center items-center shadow-lg mt-10">
    <div class="contain bg-primary rounded w-96">
      <div class="m-12">
        <h1 class="text-6xl text-center">login</h1>
      </div>
      <div class="flex justify-center">
        <form class="flex flex-col rounded p-7" @submit.prevent="login">
          <label class="font-semibold text-xs" for="usernameField">
            Email</label
          >
          <input
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
          <label class="font-semibold text-xs mt-3" for="passwordField"
            >Password</label
          >
          <input class="form-input" type="password" v-model="form.password" />
          <small
            class="errors text-secondary mt-4"
            v-if="form.errors && form.errors.password"
          >
            {{ form.errors.password[0] }}
          </small>
          <div class="mt-3">
            <label class="inline-flex items-center">
              <input
                type="checkbox"
                class="
                  checkbox
                  transition
                  form-checkbox
                  bg-transparent
                  rounded
                  focus:text-secondary
                  focus:outline-none
                  focus:ring-2 focus:ring-secondary
                "
                checked
                v-model="form.remember"
              />
              <span class="ml-2">remember me</span>
            </label>
          </div>

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
            Login
          </button>
          <div class="flex mt-6 justify-center text-xs">
            <button
              class="transition text-secondary hover:text-white"
              @click="forgetPassword"
            >
              Forgot Password
            </button>
            <span class="mx-2 text-gray-300">/</span>
            <router-link
              class="transition text-secondary hover:text-white"
              :to="{ name: 'admin.register' }"
              >Sign Up</router-link
            >
          </div>
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
        email: null,
        password: null,
        remember: false,
        errors: null,
      },
    };
  }, //end of data

  methods: {
    login() {
      this.loading = true;
      this.form.errors = null;
      axios
        .post("/login", this.form)
        .then((response) => {
          if (response.status == 200) {
            this.$router.push({ name: "admin.dashboard" });
          }
        })
        .catch((error) => {
          this.form.errors = error.response.data.errors;
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of login

    forgetPassword() {
      alert("relax and try to remember it");
    }, //end of password
  }, //end of methods

  async beforeRouteEnter(to, from, next) {
    try {
      let user = (await axios.get("/user")).data;
      next({ name: "admin.dashboard" });
    } catch (error) {
      if (error.response.status == 401) {
        next();
      }
      if (error.response.status == 403) {
        next({ name: "forbidden" });
      }
    }
  },
};
</script>

<style scoped>
.checkbox:checked {
  color: #fca311;
}
</style>