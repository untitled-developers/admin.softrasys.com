<template>
<BasePageContent>
        <BaseCrudTable
            endpoint="api/resellerForms"
            :with-add="false"
            :edit-dialog="TheResellerFormInfoDialog"
            :edit-button-config="{ label: 'Info' }">
            <template #columns>
                <Column field="id" header="ID" :sortable="true"/>
                <Column field="name" header="Name" :sortable="true"/>
                <Column field="phone" header="Phone" :sortable="true"/>
                <Column field="email" header="Email" :sortable="true"/>
                <Column field="industry" header="Industry" :sortable="true"/>
                <Column field="company_name" header="Company Name" :sortable="true"/>
                <Column field="website" header="Website" :sortable="true"/>
                <Column field="created_at" header="Submission Date" :sortable="true"/>
            </template>
        </BaseCrudTable>
    </BasePageContent>
</template>

<script setup>
import BasePageContent from "kockatoos-admin-ui/components/BasePageContent.vue";
import BaseCrudTable from "kockatoos-admin-ui/components/BaseCrudTable.vue";
import Column from "primevue/column";
import TheResellerFormInfoDialog from "@/js/app/pages/forms/resellerForm/dialogs/TheResellerFormInfoDialog.vue";

</script>
