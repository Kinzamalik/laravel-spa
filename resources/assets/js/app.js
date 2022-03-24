import Vue from "vue";

import App from "./App.vue";
import router from "./router";
import bar from "./components/progress";

// Vue.component(
//     "example-component",
//     require("./components/ExampleComponent.vue").default
// );

router.beforeEach((to, from, next) => {
    bar.start();
    next();
});

Vue.filter("formatMoney", (value) => {
    return Number(value)
        .toFixed(2)
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
});
console.log("test11");
const app = new Vue({
    el: "#root",
    render: (h) => h(App),
    router,
});
