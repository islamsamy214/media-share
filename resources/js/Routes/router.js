import { createRouter, createWebHistory } from "vue-router";
import WebLayout from "../Layouts/Web/App.vue";
import web from "./Web/routes";
import AdminLayout from "../Layouts/Admin/App.vue";
import admin from "./Admin/routes";
import HomePage from '../Pages/Home/HomePage.vue';
import Login from "../Pages/Admin/Auth/Login.vue";
import Register from "../Pages/Admin/Auth/Register.vue";
import NotFoundPage from "../Pages/Abort/NotFound/NotFoundPage.vue";
import ForbiddenPage from "../Pages/Abort/Forbidden/ForbiddenPage.vue";

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes: [
        /////////////////////////////// layouts ////////////////////////////////////
        {
            name: "web",
            path: "/",
            component: WebLayout,
            children: web,
            redirect: { name: "home" },
        },
        {
            name: "admin",
            path: "/admin",
            component: AdminLayout,
            children: admin,
            redirect: { name: "admin.dashboard" },
        },
        ////////////////////////////////// home or starter page ////////////////////
        {
            name: "home",
            path: "/home",
            component: HomePage,
        },
        ////////////////////////////////// admin auth //////////////////////////////
        {
            name: "admin.login",
            path: "/admin/login",
            component: Login,
        },
        {
            name: "admin.register",
            path: "/admin/register",
            component: Register,
        },
        ////////////////////////////////// abort pages //////////////////////////////
        {
            name: "notfound",
            path: "/:notfound(.*)",
            component: NotFoundPage,
        },
        {
            name: "forbidden",
            path: "/forbidden",
            component: ForbiddenPage,
        },
    ],
});

export default router;
