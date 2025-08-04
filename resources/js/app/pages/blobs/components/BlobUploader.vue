<template>
    <div>
        <FileUpload ref="fileupload" auto
                    mode="basic"
                    name="image"
                    url="/api/blobs"
                    accept="image/*"
                    :maxFileSize="1000000"
                    @upload="handleUpload"/>
    </div>
</template>

<script setup>
import {FileUpload} from "primevue";

function handleUpload(event) {
    console.log('File Upload')
    console.log(event.files);
}
</script>
