<template>
    <BaseEditDialog
        form-id="gps-stat-form"
        :record="record"
        record-type="GPS Stat"
        endpoint="api/gps_stats"
        :request-body-mapper="requestBodyMapper"
        :record-mapper="recordMapper"
        v-model:form="form"
        v-model:form-schema="formSchema"
        @submit="emit('submit')"
        @next-record="emit('next-record', record)"
        @previous-record="emit('previous-record', record)"
        @close="emit('close')"
        ref="dialog"
        width="800px"
    >
        <template #content="{getErrors, handleSubmit, didSubmit}">
            <form id="gps-stat-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">
                <div class="grid grid-cols-12 gap-y-4 gap-x-2">
                    <div class="col-span-6">
                        <BaseInputContainer
                            label="Value*"
                            :errors="getErrors('value')"
                            :show-errors="didSubmit">
                            <InputNumber class="w-full" v-model="form.value" :min="0" :useGrouping="false"/>
                        </BaseInputContainer>
                    </div>
                    <div class="col-span-6">
                        <BaseInputContainer label="Suffix">
                            <InputText class="w-full" maxlength="10" v-model="form.suffix" placeholder="+"/>
                        </BaseInputContainer>
                    </div>
                    <div class="col-span-12">
                        <BaseInputContainer label="Sort Number">
                            <InputNumber class="w-full" v-model="form.sort_number"/>
                        </BaseInputContainer>
                    </div>

                    <div class="col-span-12">
                        <Tabs :value="languagesStore.languages[0]?.id">
                            <TabList>
                                <Tab v-for="lang in languagesStore.languages" :value="lang.id">
                                    <template #default>
                                        <BaseDialogTabLabel
                                            :get-errors="getErrors"
                                            :show-errors="didSubmit"
                                            :fields="[
                                                `languages.${lang.code}.title`,
                                                `languages.${lang.code}.subtitle`,
                                            ]"
                                            :label="lang.name">
                                        </BaseDialogTabLabel>
                                    </template>
                                </Tab>
                            </TabList>
                            <TabPanels>
                                <TabPanel v-for="lang in languagesStore.languages" :value="lang.id">
                                    <div class="flex flex-col gap-y-4">
                                        <BaseInputContainer
                                            :show-errors="didSubmit"
                                            label="Title"
                                            :errors="getErrors(`languages.${lang.code}.title`)">
                                            <InputText maxlength="120" v-model="form.languages[lang.code].title"/>
                                        </BaseInputContainer>

                                        <BaseInputContainer
                                            label="Subtitle">
                                            <Textarea class="w-full"
                                                      v-model="form.languages[lang.code].subtitle"
                                                      :maxlength="255"
                                                      :rows="3"/>
                                        </BaseInputContainer>
                                    </div>
                                </TabPanel>
                            </TabPanels>
                        </Tabs>
                    </div>
                </div>
            </form>
        </template>
    </BaseEditDialog>
</template>

<script setup>
import Textarea from "primevue/textarea";
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import BaseInputContainer from "kockatoos-admin-ui/components/BaseInputContainer.vue";
import {ref, onBeforeMount} from "vue";
import * as zod from "zod";
import useCreateFormSchema from "kockatoos-admin-ui/composables/useCreateFormSchema.js";
import useEditDialog from "kockatoos-admin-ui/composables/useEditDialog.js";
import TabList from "primevue/tablist";
import Tab from "primevue/tab";
import TabPanel from "primevue/tabpanel";
import BaseDialogTabLabel from "kockatoos-admin-ui/components/BaseDialogTabLabel.vue";
import TabPanels from "primevue/tabpanels";
import Tabs from "primevue/tabs";
import {useLanguagesStore} from "kockatoos-admin-ui/stores/LanguagesStore.js";

const props = defineProps({
    record: Object,
})
const emit = defineEmits(['close', 'submit', 'next-record', 'previous-record'])
const dialog = ref(null)
const {startDialogLoading, stopDialogLoading} = useEditDialog(dialog)
const languagesStore = useLanguagesStore()
const {createFormSchema} = useCreateFormSchema({props})

const form = ref({
    value: 0,
    suffix: '+',
    sort_number: 0,
    languages: {}
})

const formSchema = createFormSchema(
    zod.object({
        value: zod.number({message: 'Value is required'}).min(0, 'Value must be positive'),
    }),
    {
        languages: languagesStore.languages.map(lang => lang.code),
        requiredLanguages: ['en'],
        languageSchema: zod.object({
            title: zod.string().nonempty('Title is required'),
            subtitle: zod.string().optional().nullable(),
        })
    })

function requestBodyMapper(data) {
    let newData = {...data}
    return {
        data: newData,
    }
}

async function recordMapper(data) {
    let newData = {...data}
    newData.languages = {}

    try {
        startDialogLoading({
            blockUI: true,
            message: 'Fetching GPS stat information...'
        })

        if (props.record?.id) {
            const response = await window.axios.get(`api/gps_stats/${props.record.id}`)
            newData = response.data
            newData.value = Number(newData.value)

            languagesStore.languages.forEach(lang => {
                if (!newData.languages[lang.code]) {
                    newData.languages[lang.code] = {
                        language_id: lang.id,
                        title: '',
                        subtitle: '',
                    }
                }
            })
        }

        return newData
    } catch (error) {
        console.error(error)
        return newData
    } finally {
        stopDialogLoading()
    }
}

onBeforeMount(() => {
    languagesStore.languages.forEach(lang => {
        form.value.languages[lang.code] = {
            language_id: lang.id,
            title: '',
            subtitle: '',
        }
    })
})
</script>

<style scoped>
</style>
