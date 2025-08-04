<template>
    <BasePageContent>
        <BaseCrudTable
            :with-add="false"
            :edit-dialog="TheAdminDialog"
            endpoint="api/blobs">
            <template #controls-start>
                <Button @click="handleUploadButtonClick" label="Upload" icon="pi pi-upload"></Button>
            </template>
            <template #columns>
                <Column field="id" header="ID" :sortable="true"/>
                <Column field="url" header="URL" :sortable="true"/>
                <Column field="type" header="Type" :sortable="true"/>
                <Column field="size" header="Size" :sortable="true"/>
                <Column field="ext" header="Extension" :sortable="true"/>
                <Column field="name" header="Name" :sortable="true"/>
                <Column field="directory" header="Directory" :sortable="true"/>
                <Column field="base_url" header="Base URL" :sortable="true"/>
                <Column field="sort_number" header="Sort" :sortable="true"/>
                <Column field="created_at" header="Created At" :sortable="true"/>
                <Column field="updated_at" header="Updated At" :sortable="true"/>
                <Column field="deleted_at" header="Deleted At" :sortable="true"/>
            </template>
        </BaseCrudTable>
    </BasePageContent>
</template>

<script setup>
import BasePageContent from "kockatoos-admin-ui/components/BasePageContent.vue";
import BaseCrudTable from "kockatoos-admin-ui/components/BaseCrudTable.vue";
import Column from "primevue/column";
import {Button} from "primevue";
import TheAdminDialog from "@/js/app/pages/admins/dialogs/TheAdminDialog.vue";
import useDialog from "kockatoos-admin-ui/composables/useDialog.js";
import TheBlobUploadDialog from "@/js/app/pages/blobs/dialogs/TheBlobUploadDialog.vue";

const {openDialog} = useDialog()

function handleUploadButtonClick() {
    openDialog(TheBlobUploadDialog)
}


</script>
