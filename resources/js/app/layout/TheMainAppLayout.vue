<template>
    <BaseMainLayout :navigation-items="items">
        <template #logo>
            <img src="images/logo.png" class="h-28 w-auto p-1">
        </template>
        <template #main>
            <router-view></router-view>
        </template>
    </BaseMainLayout>
</template>

<script setup>
import BaseMainLayout from "kockatoos-admin-ui/components/BaseMainLayout.vue";
import {ref} from "vue";


const items = ref([
    {
        label: 'Admins',
        route: {
            name: 'Admins'
        }
    },
    {
        label: 'Blobs',
        route: {
            name: 'Blobs'
        }
    }
]);
</script>

<style scoped>


</style>
