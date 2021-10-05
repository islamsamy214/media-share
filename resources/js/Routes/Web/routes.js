import AboutPage from "../../Pages/Web/About/AboutPage.vue";
import UserShow from "../../Pages/Web/About/Users/User/UserShow.vue";
import WorkPage from "../../Pages/Web/Work/WorkPage.vue";
import BlogPage from "../../Pages/Web/Blogs/BlogPage.vue";
import ContactPage from "../../Pages/Web/Contact/ContactPage.vue";
import BlogShow from "../../Pages/Web/Blogs/Show/BlogShow.vue";
import WorkShow from "../../Pages/Web/Work/Show/WorkShow.vue";

const web = [
    ////////////////////////////////// web routes ////////////////////////////
    //about
    {
        name: "about",
        path: "about",
        component: AboutPage,
        children: [
            {
                name: "about.users.show",
                path: "users/:slug",
                component: UserShow,
                params: true,
            },
        ],
    },
    //works
    {
        name: "works",
        path: "works",
        component: WorkPage,
    },
    {
        name: "works.show",
        path: "works/:id/:slug",
        component: WorkShow,
    },
    //contact
    {
        name: "contact",
        path: "contact",
        component: ContactPage,
    },
    //blogs
    {
        name: "blogs",
        path: "blogs",
        component: BlogPage,
    },
    {
        name: "blogs.show",
        path: "blogs/:id/:slug",
        component: BlogShow,
    },
];

export default web;
