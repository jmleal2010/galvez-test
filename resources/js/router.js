import Dashboard from "./components/common/Dashboard.vue";
import {createRouter, createWebHistory} from "vue-router";
import Calendar from "./components/common/Calendar.vue";
import Checklist from "./components/common/Checklist.vue";

const routes = [
    {path: '/', component: Dashboard},
    {path: '/checklist', component: Checklist, name: 'Checklist'},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
