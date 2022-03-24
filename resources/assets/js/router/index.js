import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        { path: "/", redirect: "invoices" },
        {
            path: "/invoices",
            component: require("../views/invoices/index.vue").default,
        },
        {
            path: "/invoices/create",
            component: require("../views/invoices/form.vue").default,
        },
        {
            path: "/invoices/:id/edit",
            component: require("../views/invoices/form.vue").default,
            meta: { model: "edit" },
        },
        {
            path: "/invoices/:id",
            component: require("../views/invoices/show.vue").default,
        },
    ],
});

export default router;