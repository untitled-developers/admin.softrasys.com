<template>
    <BasePageContent>
        <BaseCrudTable :edit-dialog="TheSolutionCategoryDialog"
                       endpoint="api/solution_categories"
                       ref="crudTable">
            <template #columns>
                <Column field="blob_url" header="Image">
                    <template #body="{data}">
                        <div class="flex items-center">
                            <div class="shrink-0 mr-2">
                                <BaseImageDisplay :url="data.blob_url" class="size-16"/>
                            </div>
                        </div>
                    </template>
                </Column>
                <Column field="id" header="ID" :sortable="true"></Column>
                <Column field="name" header="Name" :sortable="true"></Column>
                <Column field="sort_number" header="Sort Number" :sortable="true"></Column>
                <Column field="is_featured" header="Featured" :sortable="true">
                    <template #body="{data}">
                        <BaseTableToggleSelect
                            @change="handleToggleFeatured($event, data)"
                            :options="[
                                {
                                    label: 'Featured',
                                    value: 1
                                },
                                {
                                    label: 'Not Featured',
                                    value: 0
                                }
                            ]"
                            :value="data.is_featured ? 1 : 0"
                            :color-mapping="{
                                1: 'green',
                                0: ''
                            }"
                        />
                    </template>
                </Column>

                <Column field="is_header_menu" header="Header Menu" :sortable="true">
                    <template #body="{data}">
                        <BaseTableToggleSelect
                            @change="handleToggleHeaderMenu($event, data)"
                            :options="[
                                {
                                    label: 'In Menu',
                                    value: 1
                                },
                                {
                                    label: 'Not In Menu',
                                    value: 0
                                }
                            ]"
                            :value="data.is_header_menu ? 1 : 0"
                            :color-mapping="{
                                1: 'green',
                                0: ''
                            }"
                        />
                    </template>
                </Column>

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
import TheSolutionCategoryDialog from "@/js/app/pages/solutionCategories/dialogs/TheSolutionCategoryDialog.vue";
import BaseImageDisplay from "kockatoos-admin-ui/components/BaseImageDisplay.vue";


const crudTable = ref();

const {alertError} = useAlerts();
const {
    stopRowLoading,
    startRowLoading
} = useCrudTable(crudTable);


async function handleToggleFeatured(value, record) {
    startRowLoading(record);

    try {
        const response = await window.axios.put(`api/solution_categories/${record.id}/toggleFeatured`);
        record.is_featured = response.data.is_featured;
    } catch (e) {
        console.error(e);
    } finally {
        stopRowLoading(record);
    }
}
async function handleToggleHeaderMenu(value, record) {
    startRowLoading(record);
    try {
        const response = await window.axios.put(`api/solution_categories/${record.id}/toggleHeaderMenu`);
        record.is_header_menu = response.data.is_header_menu;
    } catch (e) {
        alertError('Error', 'Failed to update header menu status');
    } finally {
        stopRowLoading(record);
    }
}
async function handleToggleHidden(value, record) {
    startRowLoading(record);
    try {
        await window.axios.put(`api/solution_categories/${record.id}/toggleHidden`);
    } catch (e) {
        alertError('Error', 'Failed to update status');
    } finally {
        stopRowLoading(record);
    }
}

</script>

<style scoped>

</style>
