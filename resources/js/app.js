import './bootstrap';
import '../css/app.css';
import 'primeicons/primeicons.css'
import { createApp, h } from 'vue';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import { createInertiaApp } from '@inertiajs/vue3'
import Aura from '@primeuix/themes/aura';

createInertiaApp({
    resolve: name => {
      const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
      return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
      createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ConfirmationService)
        .use(PrimeVue, {
            theme: {
                preset: Aura,
                options: {
                  prefix: 'p',
                  darkModeSelector: '.dark',
                  cssLayer: false,
                },
            }
        })
        .mount(el)
    },
  })
