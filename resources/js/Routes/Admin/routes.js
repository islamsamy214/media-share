import DashboardPage from "../../Pages/Admin/Dashboard/DashboardPage.vue";
import UserPage from "../../Pages/Admin/Users/UserPage.vue";
import UserCreate from "../../Pages/Admin/Users/Create/UserCreate.vue";
import UserEdit from "../../Pages/Admin/Users/Edit/UserEdit.vue";
import ProfileEdit from "../../Pages/Admin/Users/Edit/Profile/ProfileEdit.vue";
import BlogCategoryPage from "../../Pages/Admin/BlogCategory/BlogCategoryPage.vue";
import BlogCategoryCreate from "../../Pages/Admin/BlogCategory/Create/BlogCategoryCreate.vue";
import BlogCategoryEdit from "../../Pages/Admin/BlogCategory/Edit/BlogCategoryEdit.vue";
import BlogPage from "../../Pages/Admin/Blog/BlogPage.vue";
import BlogShow from "../../Pages/Admin/Blog/Show/BlogShow.vue";
import BlogCreate from "../../Pages/Admin/Blog/Create/BlogCreate.vue";
import BlogEdit from "../../Pages/Admin/Blog/Edit/BlogEdit.vue";
import WorkCategoryPage from "../../Pages/Admin/WorkCategory/WorkCategoryPage.vue";
import WorkCategoryCreate from "../../Pages/Admin/WorkCategory/Create/WorkCategoryCreate.vue";
import WorkCategoryEdit from "../../Pages/Admin/WorkCategory/Edit/WorkCategoryEdit.vue";
import WorkPage from "../../Pages/Admin/Work/WorkPage.vue";
import WorkShow from "../../Pages/Admin/Work/Show/WorkShow.vue";
import WorkCreate from "../../Pages/Admin/Work/Create/WorkCreate.vue";
import WorkEdit from "../../Pages/Admin/Work/Edit/WorkEdit.vue";
import MessagePage from "../../Pages/Admin/Messages/MessagePage.vue";
import MessageShow from "../../Pages/Admin/Messages/Show/MessageShow.vue";
import MessageEdit from "../../Pages/Admin/Messages/Edit/ContactEdit.vue";

const admin = [
    ////////////////////////////////// admin routes ////////////////////////////
    //dashboard
    {
        name: "admin.dashboard",
        path: "dashboard",
        component: DashboardPage,
    },
    //users
    {
        name: "admin.users",
        path: "users",
        component: UserPage,
    },
    {
        name: "admin.users.create",
        path: "users/create",
        component: UserCreate,
    },
    {
        name: "admin.users.edit",
        path: "users/edit/:slug",
        component: UserEdit,
        params: true,
    },
    {
        name: "admin.users.edit.profile",
        path: "users/edit/:slug/profile",
        component: ProfileEdit,
        params: true,
    },
    //blog categories
    {
        name: "admin.blogcategories",
        path: "blog/categories",
        component: BlogCategoryPage,
    },
    {
        name: "admin.blogcategories.create",
        path: "blog/categories/create",
        component: BlogCategoryCreate,
    },
    {
        name: "admin.blogcategories.edit",
        path: "blog/categories/edit/:slug",
        component: BlogCategoryEdit,
        params: true,
    },
    //blogs
    {
        name: "admin.blogs",
        path: "blogs",
        component: BlogPage,
    },
    {
        name: "admin.blogs.show",
        path: "blogs/:id/:slug",
        component: BlogShow,
    },
    {
        name: "admin.blogs.create",
        path: "blogs/create",
        component: BlogCreate,
    },
    {
        name: "admin.blogs.edit",
        path: "blogs/edit/:slug",
        component: BlogEdit,
        params: true,
    },
    //work categories
    {
        name: "admin.workcategories",
        path: "work/categories",
        component: WorkCategoryPage,
    },
    {
        name: "admin.workcategories.create",
        path: "work/categories/create",
        component: WorkCategoryCreate,
    },
    {
        name: "admin.workcategories.edit",
        path: "work/categories/edit/:slug",
        component: WorkCategoryEdit,
        params: true,
    },
    //works
    {
        name: "admin.works",
        path: "works",
        component: WorkPage,
    },
    {
        name: "admin.works.show",
        path: "works/:id/:slug",
        component: WorkShow,
    },
    {
        name: "admin.works.create",
        path: "works/create",
        component: WorkCreate,
    },
    {
        name: "admin.works.edit",
        path: "works/edit/:slug",
        component: WorkEdit,
        params: true,
    },
    //Messages
    {
        name: "admin.messages",
        path: "messages",
        component: MessagePage,
    },
    {
        name: "admin.messages.show",
        path: "messages/:id/:slug",
        component: MessageShow,
    },
    {
        name: "admin.contact.edit",
        path: "contact/edit",
        component: MessageEdit,
    },
];

export default admin;
