<template>
  <alert></alert>
  <div class="flex flex-col max-w-screen overflow-hidden">
    <nav-bar></nav-bar>
    <div class="flex flex-col md:flex-row justify-between">
      <div class="m-4 p-4 md:w-64 bg-primary rounded-xl h-full">
        <left-ad></left-ad>
      </div>
      <div class="m-4 md:my-4 p-4 md:w-full bg-primary rounded-xl">
        <router-view></router-view>
      </div>
      <div class="m-4 p-4 md:w-64 bg-primary rounded-xl h-full">
        <right-ad></right-ad>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from "./Bars/NavBar.vue";
import LeftAd from "./Ads/LeftAd.vue";
import RightAd from "./Ads/RightAd.vue";
import Alert from "../../Components/Alert.vue";

export default {
  components: {
    NavBar,
    LeftAd,
    RightAd,
    Alert,
  }, //end of components
  created() {
    axios.get("/api/visit");
  }, //end of created
};
</script>