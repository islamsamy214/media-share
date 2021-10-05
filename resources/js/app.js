require("./bootstrap");

import { createApp } from "vue";
import App from "./App.vue";
import router from "./Routes/router";
import store from "./Store/index";
import { Icon } from "@iconify/vue";

import Loading from "./Components/Loading.vue";
import Alert from "./Components/Alert.vue";
import ConfirmAlert from "./Components/ConfirmAlert.vue";
import ButtonsList from './Components/ButtonsList.vue';

const app = createApp(App);
app.use(router);
app.use(store);

app.component("icon", Icon);
app.component("loading", Loading);
app.component("alert", Alert);
app.component("confirm-alert", ConfirmAlert);
app.component("buttons-list", ButtonsList);

app.mount("#app");
