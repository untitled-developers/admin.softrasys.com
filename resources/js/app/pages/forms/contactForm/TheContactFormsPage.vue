<template>
<BasePageContent>
        <BaseCrudTable
            endpoint="api/contactForms"
            :with-add="false"
            :edit-dialog="TheContactFormInfoDialog"
            :edit-button-config="{ label: 'Info' }">
            <template #columns>
                <Column field="id" header="ID" :sortable="true"/>
                <Column field="name" header="Name" :sortable="true"/>
                <Column field="phone" header="Phone" :sortable="true"/>
                <Column field="email" header="Email" :sortable="true"/>
                <Column field="industry" header="Industry" :sortable="true"/>
                <Column field="number_of_vehicles" header="Number of Vehicles" :sortable="true"/>
                <Column field="country" header="Country" :sortable="true"/>
                <Column field="created_at" header="Submission Date" :sortable="true"/>
            </template>
        </BaseCrudTable>
    </BasePageContent>
</template>

<script setup>
import BasePageContent from "kockatoos-admin-ui/components/BasePageContent.vue";
import BaseCrudTable from "kockatoos-admin-ui/components/BaseCrudTable.vue";
import Column from "primevue/column";
import TheContactFormInfoDialog from "@/js/app/pages/forms/contactForm/dialogs/TheContactFormInfoDialog.vue";

</script>
