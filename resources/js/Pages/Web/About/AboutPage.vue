<template>
  <div>
    <about-user></about-user>
    <about-us></about-us>
  </div>
</template>

<script>
import AboutUs from "./AboutUs.vue";
import AboutUser from "./Users/AboutUser.vue";

export default {
  components: { AboutUs, AboutUser },
};
</script>