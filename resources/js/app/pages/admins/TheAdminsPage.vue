<template>
    <BasePageContent>
        <BaseCrudTable
            v-if="didFetchRoles"
            :edit-dialog="TheAdminDialog"
            endpoint="api/admins" ref="crudTable">
            <template #columns>
                <Column field="id" header="ID" :sortable="true"/>
                <Column field="name" :sortable="true" header="Name"></Column>
                <Column field="username" :sortable="true" header="Username"/>
                <Column field="phone" :sortable="true" header="Phone"/>
                <Column header="Role">
                    <template #body="{data}">
                        {{data.roles[0]?.display_name}}
                    </template>
                </Column>
                <Column field="is_locked" :sortable="true" header="Status">
                    <template #body="{data}">
                        <BaseTableToggleSelect
                            @change="handleAdminStatusChange($event, data)"
                            :options="[
                                {
                                    label: 'Active',
                                    value: 0
                                },
                                {
                                    label: 'Locked',
                                    value: 1
                                }
                            ]"
                            :value="data.is_locked ? 1 : 0"
                            :color-mapping="{
                                0: 'green',
                                1: ''
                            }"
                        />
                    </template>
                </Column>
            </template>
        </BaseCrudTable>
        <BaseLoaderOverlay v-else></BaseLoaderOverlay>
    </BasePageContent>
</template>

<script setup>
import BasePageContent from "kockatoos-admin-ui/components/BasePageContent.vue";
import BaseLoaderOverlay from "kockatoos-admin-ui/components/BaseLoaderOverlay.vue";
import BaseCrudTable from "kockatoos-admin-ui/components/BaseCrudTable.vue";
import BaseTableToggleSelect from "kockatoos-admin-ui/components/BaseTableToggleSelect.vue";
import Column from "primevue/column";
import {onMounted, ref} from "vue";
import useCrudTable from "kockatoos-admin-ui/composables/useCrudTable.js";
import useAlerts from "kockatoos-admin-ui/composables/useAlerts.js";
import TheAdminDialog from "@/js/app/pages/admins/dialogs/TheAdminDialog.vue";

const crudTable = ref();
const {alertError} = useAlerts();
const {
    stopRowLoading,
    startRowLoading
} = useCrudTable(crudTable);
const roles = ref([])
const didFetchRoles = ref(false);

async function getRoles() {
    try {
        const response = await window.axios.get('api/admins/formData');
        roles.value = response.data.roles;
    } catch (error) {
        alertError('Error', 'Failed to fetch roles');
    } finally {
        didFetchRoles.value = true
    }
}

async function handleAdminStatusChange(value, record) {
    startRowLoading(record);

    try {
        const newFormData = new FormData();
        newFormData.append('data', JSON.stringify({
            ...record,
            is_locked: value === 1
        }));

        await window.axios.put(`api/admins/${record.id}/toggleLocked`, newFormData);
    } catch (e) {
        alertError('Error', 'Failed to update admin status');
    } finally {
        stopRowLoading(record);
    }
}

onMounted(() => {
    getRoles();
})
</script>
