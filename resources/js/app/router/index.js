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
                    path: '/careers',
                    name: 'Careers',
                    component: () => import('@/js/app/pages/careers/TheCareersPage.vue'),
                    meta: {
                        title: 'Careers'
                    }
                },
                {
                    path: '/solutions',
                    name: 'Solutions',
                    component: () => import('@/js/app/pages/solutions/TheSolutionsPage.vue'),
                    meta: {
                        title: 'Solutions'
                    }
                },
                {
                    path: '/industries',
                    name: 'Industries',
                    component: () => import('@/js/app/pages/industries/TheIndustriesPage.vue'),
                    meta: {
                        title: 'Industries'
                    }
                },
                {
                    path: '/accessory',
                    name: 'Accessory',
                    component: () => import('@/js/app/pages/accessories/TheAccessoriesPage.vue'),
                    meta: {
                        title: 'Accessory'
                    }
                },
                {
                    path: '/locations',
                    name: 'Locations',
                    component: () => import('@/js/app/pages/locations/TheLocationsPage.vue'),
                    meta: {
                        title: 'Locations'
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
                {
                    path: '/reseller_forms',
                    name: 'Reseller Forms',
                    component: () => import('@/js/app/pages/forms/resellerForm/TheResellerFormsPage.vue'),
                    meta: {
                        title: 'Reseller Forms'
                    }
                },
                {
                    path: '/demo_forms',
                    name: 'Demo Forms',
                    component: () => import('@/js/app/pages/forms/demoForm/TheDemoFormsPage.vue'),
                    meta: {
                        title: 'Demo Forms'
                    }
                },

            ]
        }
    ]
})

export default router
