import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "@/router";
import VueSelect from "vue-select";
import notifications from "@kyvg/vue3-notification";

import "vue-select/dist/vue-select.css";

const app = createApp(App);

app.use(router);
app.use(notifications);

app.component("v-select", VueSelect);

app.mount("#app");
