import {createRouter, createWebHashHistory} from "vue-router";
import TheMainAppLayout from "@/js/app/layout/TheMainAppLayout.vue";

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: '/',
            name: 'main',
            component: TheMainAppLayout,
            redirect: {
                name: 'Admins'
            },
            children: [
                {
                    path: '/admins',
                    name: 'Admins',
                    component: () => import('@/js/app/pages/admins/TheAdminsPage.vue'),
                    meta: {
                        title: 'Admins'
                    }
                },
                {
                    path: '/testimonials',
                    name: 'Testimonials',
                    component: () => import('@/js/app/pages/testimonials/TheTestimonialsPage.vue'),
                    meta: {
                        title: 'Testimonials'
                    }
                },
                {
                    path: '/faqs',
                    name: 'Faqs',
                    component: () => import('@/js/app/pages/faqs/TheFaqsPage.vue'),
                    meta: {
                        title: 'Faqs'
                    }
                },

                {
                    path: '/blobs',
                    name: 'Blobs',
                    component: () => import('@/js/app/pages/blobs/TheBlobsPage.vue'),
                    meta: {
                        title: 'Blobs'
                    }
                },
                {
                    path: '/contact_forms',
                    name: 'Contact Forms',
                    component: () => import('@/js/app/pages/forms/contactForm/TheContactFormsPage.vue'),
                    meta: {
                        title: 'Contact Forms'
                    }
                },

            ]
        }
    ]
})

export default router
