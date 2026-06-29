<template>
<BasePageContent>
        <BaseCrudTable
            endpoint="api/contactForms"
            :with-add="false"
            with-clear-filters
            edit-mode="cell"
            :filters="filters"
            :edit-dialog="TheContactFormInfoDialog"
            :edit-button-config="{ label: 'Info' }"
            ref="crudTable">
            <template #columns="{ isFilterActive }">
                <Column field="id" header="ID" :sortable="true"/>
                <Column field="name" header="Name" :sortable="true"/>
                <Column field="phone_number" header="Phone" :sortable="true"/>
                <Column field="email" header="Email" :sortable="true"/>
                <Column field="industry" header="Industry" :sortable="true"/>
                <Column field="number_of_vehicles" header="Number of Vehicles" :sortable="true"/>
                <Column field="country" header="Country" :sortable="true"/>

                <Column field="status" filterField="status" :showFilterMatchModes="false"
                    :filterMenuStyle="{ width: '14rem' }" :sortable="true" header="Status">
                    <template #filtericon>
                        <BaseCrudTableFilterButton :is-active="isFilterActive('status')" />
                    </template>
                    <template #editor="{ data, field }">
                        <Select :options="statuses" option-label="label" option-value="value" class="w-full"
                            @change="handleCellEditComplete($event, field, data)" v-model="data[field]">
                            <template #option="slotProps">
                                <Tag :severity="slotProps.option.severity" :value="slotProps.option.value">
                                    {{ slotProps.option.label }}
                                </Tag>
                            </template>
                        </Select>
                    </template>
                    <template #body="slotProps">
                        <Tag v-if="slotProps.data.status === 'Intake'" severity="secondary" value="Intake" />
                        <Tag v-else-if="slotProps.data.status === 'Unqualified'" severity="danger" value="Unqualified" />
                        <Tag v-else-if="slotProps.data.status === 'Qualified'" severity="info" value="Qualified" />
                        <Tag v-else-if="slotProps.data.status === 'Converted'" severity="success" value="Converted" />
                    </template>
                    <template #filter="{ filterModel }">
                        <Select :options="statuses" option-label="label" option-value="value" class="p-column-filter"
                            placeholder="Any" v-model="filterModel.value">
                            <template #option="slotProps">
                                <Tag :severity="slotProps.option.severity" :value="slotProps.option.value">
                                    {{ slotProps.option.label }}
                                </Tag>
                            </template>
                        </Select>
                    </template>
                </Column>

                <Column field="is_read" header="Read Status" :sortable="true">
                    <template #body="{ data }">
                        <Button readonly :label="data.is_read ? 'Read' : 'Unread'" size="small" rounded
                            :severity="data.is_read ? 'success' : 'secondary'" />
                    </template>
                </Column>

                <Column field="created_at" header="Submission Date" :sortable="true"/>
            </template>
        </BaseCrudTable>
    </BasePageContent>
</template>

<script setup>
import BasePageContent from "kockatoos-admin-ui/components/BasePageContent.vue";
import BaseCrudTable from "kockatoos-admin-ui/components/BaseCrudTable.vue";
import { ref } from "vue";
import useAlerts from "kockatoos-admin-ui/composables/useAlerts.js";
import useCrudTable from "kockatoos-admin-ui/composables/useCrudTable.js";
import Column from "primevue/column";
import Tag from 'primevue/tag';
import { FilterMatchMode } from '@primevue/core/api';
import Select from "primevue/select";
import Button from "primevue/button";
import TheContactFormInfoDialog from "@/js/app/pages/forms/contactForm/dialogs/TheContactFormInfoDialog.vue";
import BaseCrudTableFilterButton from "kockatoos-admin-ui/components/BaseCrudTableFilterButton.vue";

const crudTable = ref();
const { alertError } = useAlerts();
const { fetchTableData, stopRowLoading, startRowLoading } = useCrudTable(crudTable);
let isUpdatingData = false;

const statuses = ref([
    { label: 'Intake', value: 'Intake', severity: 'secondary' },
    { label: 'Unqualified', value: 'Unqualified', severity: 'danger' },
    { label: 'Qualified', value: 'Qualified', severity: 'info' },
    { label: 'Converted', value: 'Converted', severity: 'success' },
]);

const filters = ref({
    status: {
        value: null,
        matchMode: FilterMatchMode.EQUALS
    },
});

function handleCellEditComplete(event, field, data) {
    const post = { field, value: event.value };
    startRowLoading(data);
    isUpdatingData = true;
    axios.post(`api/contactForms/${data.id}/updateStatus`, post)
        .then(() => {
            fetchTableData();
            stopRowLoading(data);
        })
        .catch(error => {
            console.log(error);
            stopRowLoading(data);
            alertError('Error updating status');
        })
        .finally(() => {
            isUpdatingData = false;
        });
}
</script>
