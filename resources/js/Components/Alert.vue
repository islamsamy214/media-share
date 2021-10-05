<template>
  <div
    class="
      transition
      transform
      fixed
      top-0
      right-0
      border-l-4 border-green-600
      p-5
      mt-4
      bg-black
      z-10
    "
    :class="showMessage"
  >
    {{ message }}
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      message: "getMessage",
      isSetMessage: "isSetMessage",
    }),

    showMessage() {
      if (this.isSetMessage) {
        return "translate-x-0";
      } else {
        return "translate-x-full";
      }
    },
  }, //end of computed
};
</script>