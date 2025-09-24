import './bootstrap';
import {createApp} from "vue";
import App from './app/App.vue'
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css'
import router from './app/router'
import {createPinia} from "pinia";
import ConfirmationService from "primevue/confirmationservice";
import ToastService from "primevue/toastservice";
import {definePreset} from "@primeuix/themes";
import Aura from "@primeuix/themes/aura";


const customPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50:  '#F4EAFB',
            100: '#E3CCF5',
            200: '#CBA3EB',
            300: '#B279E0',
            400: '#9754D1',
            500: '#7A37B3',
            600: '#662D95',
            700: '#502376',
            800: '#3A1958',
            900: '#25103A',
            950: '#140821'
        }
    }
})


const app = createApp(App)
app.use(PrimeVue, {
    theme: {
        preset: customPreset,
        options: {
            darkModeSelector: '.dark',
            cssLayer: {
                name: 'primevue',
                order: 'theme, base, primevue'
            }
        }
    }
})
app.use(router)
app.use(ConfirmationService)
app.use(ToastService)
app.use(createPinia())
app.mount('#app')
