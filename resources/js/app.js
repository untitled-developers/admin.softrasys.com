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
            50: '{purple.50}',
            100: '{purple.100}',
            200: '{purple.200}',
            300: '{purple.300}',
            400: '{purple.400}',
            500: '{purple.500}',
            600: '{purple.600}',
            700: '{purple.700}',
            800: '{purple.800}',
            900: '{purple.900}',
            950: '{purple.950}'
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
