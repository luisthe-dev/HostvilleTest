import "./bootstrap";
import { createApp } from "vue";
import { createRouter, createWebHashHistory } from "vue-router";
import App from "./App.vue";
import SignIn from "./pages/Auth/SignIn.vue";
import Dash from "./pages/Dash/Index.vue";
import DashHome from "./pages/Dash/Home.vue";
import DashUsers from "./pages/Dash/Users.vue";
import AddUser from "./pages/Dash/AddUsers.vue";
import DashPrograms from "./pages/Dash/Programs.vue";

const routes = [
    { path: "/", component: SignIn, name: "SignIn" },
    {
        path: "/dashboard",
        component: Dash,
        children: [
            { path: "", component: DashHome },
            { path: "users", component: DashUsers },
            { path: "users/add", component: AddUser },
            { path: "programs", component: DashPrograms },
        ],
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

createApp(App).use(router).mount("#app");
