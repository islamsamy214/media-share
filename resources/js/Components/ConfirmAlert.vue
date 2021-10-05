<template>
  <div
    class="
      transition
      transform
      flex flex-col
      text-center
      fixed
      top-0
      right-0
      border-l-4 border-secondary
      p-5
      mt-4
      bg-black
      z-10
    "
    :class="showMessage"
  >
    <span class="block">{{ message }}</span>
    <div class="m-5">
      <button
        class="
          transition
          shadow
          rounded
          focus:ring-2 focus:ring-secondary
          hover:opacity-50
          p-4
          mr-5
          bg-primary
        "
        @click.prevent="confirmAnswer('yes')"
      >
        Yes
      </button>
      <button
        class="
          transition
          shadow
          rounded
          focus:ring-2 focus:ring-secondary
          hover:opacity-50
          p-4
          bg-primary
        "
        @click.prevent="confirmAnswer('no')"
      >
        No
      </button>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      isSetConfirmMessage: "isSetConfirmMessage",
      message: "getConfirmMessage",
    }), //end of store getters

    showMessage() {
      if (this.isSetConfirmMessage) {
        return "translate-x-0";
      } else {
        return "translate-x-full";
      }
    },
  }, //end of computed

  methods: {
    confirmAnswer(answer) {
      this.$store.dispatch("answerConfirmMessage", { answer: answer });
    },
  }, //end of methods
};
</script>