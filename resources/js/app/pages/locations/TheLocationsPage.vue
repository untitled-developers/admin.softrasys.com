<template>
    <BasePageContent>
        <BaseCrudTable :edit-dialog="TheLocationDialog"
                       endpoint="api/locations"
                       ref="crudTable">
            <template #columns>
                <Column field="id" header="ID" :sortable="true"></Column>
                <Column field="name" header="Name" :sortable="true"></Column>
                <Column field="phone_number" header="Phone" :sortable="true"></Column>
                <Column field="sort_number" header="Sort Number" :sortable="true"></Column>
                <Column field="is_hidden" header="Status" :sortable="true">
                    <template #body="{data}">
                        <BaseTableToggleSelect
                            @change="handleToggleHidden($event, data)"
                            :options="[
                                {
                                    label: 'Visible',
                                    value: 0
                                },
                                {
                                    label: 'Hidden',
                                    value: 1
                                }
                            ]"
                            :value="data.is_hidden ? 1 : 0"
                            :color-mapping="{
                                0: 'green',
                                1: ''
                            }"
                        />
                    </template>
                </Column>
            </template>
        </BaseCrudTable>
    </BasePageContent>
</template>

<script setup>
import Column from "primevue/column";
import BaseTableToggleSelect from "kockatoos-admin-ui/components/BaseTableToggleSelect.vue";
import BaseCrudTable from "kockatoos-admin-ui/components/BaseCrudTable.vue";
import BasePageContent from "kockatoos-admin-ui/components/BasePageContent.vue";
import useCrudTable from "kockatoos-admin-ui/composables/useCrudTable.js";
import useAlerts from "kockatoos-admin-ui/composables/useAlerts.js";
import {ref} from "vue";
import TheLocationDialog from "@/js/app/pages/locations/dialogs/TheLocationDialog.vue";


const crudTable = ref();

const {alertError} = useAlerts();
const {
    stopRowLoading,
    startRowLoading
} = useCrudTable(crudTable);



async function handleToggleHidden(value, record) {
  startRowLoading(record);
  try {
    await window.axios.put(`api/locations/${record.id}/toggleHidden`);
  } catch (e) {
    alertError('Error', 'Failed to update status');
  } finally {
    stopRowLoading(record);
  }
}

</script>

<style scoped>

</style>
