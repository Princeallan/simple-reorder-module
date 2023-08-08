import './bootstrap';
import {createApp} from 'vue'
import Notifications from '@kyvg/vue3-notification'
import router from './route'
import App from './App.vue'

const app = createApp(App)
app.use(router)
app.use(Notifications)
app.mount("#app")
