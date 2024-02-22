import './bootstrap';
import {createApp} from "vue";
import App from './components/App.vue'
import router from "./router.js";
import pinia from './store'

const app = createApp(App)

app.use(router)
    .use(pinia)
.mount("#app")
