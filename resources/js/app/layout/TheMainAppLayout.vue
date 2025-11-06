<template>
    <BaseMainLayout :navigation-items="items">
        <template #logo>
            <img src="images/logo.png" class=" w-auto pr-[20px] py-2  object-contain">
        </template>
        <template #main>
            <router-view></router-view>
        </template>
    </BaseMainLayout>
</template>

<script setup>
import BaseMainLayout from "kockatoos-admin-ui/components/BaseMainLayout.vue";
import {useLanguagesStore} from "kockatoos-admin-ui/stores/LanguagesStore.js";
import {onMounted, ref} from "vue";

const items = ref([
    {
        label: 'Admins',
        route: {
            name: 'Admins'
        }
    },
    // {
    //     label: 'Blobs',
    //     route: {
    //         name: 'Blobs'
    //     }
    // }
    {
        label: 'Testimonials',
        route: {
            name: 'Testimonials'
        }
    },
    {
        label: 'Faqs',
        route: {
            name: 'Faqs'
        }
    },
    {
        label: 'Careers',
        route: {
            name: 'Careers'
        }
    },
    {
        label: 'solutions',
        route: {
            name: 'solutions'
        }
    },
    {
        label: 'Locations',
        route: {
            name: 'Locations'
        }
    },

    {
        label: 'Forms',
        items: [
            {
                label: 'Contact Forms',
                route: {
                    name: 'Contact Forms'
                }
            },
            {
                label: 'Reseller Forms',
                route: {
                    name: 'Reseller Forms'
                }
            },
            {
                label: 'Demo Forms',
                route: {
                    name: 'Demo Forms'
                }
            },

        ]
    },

]);
const languageStore = useLanguagesStore()
const didLoadLanguages = ref(false)
async function fetchLanguages() {
    await languageStore.fetchLanguages()
    didLoadLanguages.value = true
}
onMounted(() => {
    fetchLanguages()

})
</script>

<style scoped>


</style>
