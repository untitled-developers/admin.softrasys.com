<template>
    <BaseDialog header="Upload" width="700px" full-height @close="emit('close')">
        <template #content>
            <input class="border border-gray-300 rounded-md w-full p-2 mt-4" type="file" @change="handleUploadFile">
        </template>
    </BaseDialog>
</template>

<script setup>
import BaseDialog from "kockatoos-admin-ui/components/BaseDialog.vue";

const emit = defineEmits(['close']);

function handleUploadFile(event) {
    console.log(event.target.value)
    const file = event.target.files[0];
    console.log(file)
}
</script>

<style scoped>

</style>
