require("./bootstrap")

import "@babel/polyfill";
import "mutationobserver-shim";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router/index.ts";

import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

// axios interceptors
import "./api.interceptor";

library.add(fas);

const app = createApp(App);

app.use(router);

app.component("font-awesome-icon", FontAwesomeIcon);

const el = document.getElementById('app');

app.mount(el);
