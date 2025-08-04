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
                    path: '/blobs',
                    name: 'Blobs',
                    component: () => import('@/js/app/pages/blobs/TheBlobsPage.vue'),
                    meta: {
                        title: 'Blobs'
                    }
                }
            ]
        }
    ]
})

export default router
