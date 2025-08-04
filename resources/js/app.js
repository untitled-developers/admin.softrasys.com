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
            50: '{pink.50}',
            100: '{pink.100}',
            200: '{pink.200}',
            300: '{pink.300}',
            400: '{pink.400}',
            500: '{pink.500}',
            600: '{pink.600}',
            700: '{pink.700}',
            800: '{pink.800}',
            900: '{pink.900}',
            950: '{pink.950}'
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
