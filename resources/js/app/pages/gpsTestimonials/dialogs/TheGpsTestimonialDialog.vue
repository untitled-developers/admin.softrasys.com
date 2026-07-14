<template>
    <BaseEditDialog
        form-id="gps-testimonial-form"
        :record="record"
        record-type="GPS Testimonial"
        endpoint="api/gps_testimonials"
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
            <form id="gps-testimonial-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">
                <div class="grid grid-cols-12 gap-y-4 gap-x-2">
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
                                                `languages.${lang.code}.name`,
                                                `languages.${lang.code}.text`,
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
                                            label="Name"
                                            :errors="getErrors(`languages.${lang.code}.name`)">
                                            <InputText maxlength="120" v-model="form.languages[lang.code].name"/>
                                        </BaseInputContainer>

                                        <BaseInputContainer
                                            :show-errors="didSubmit"
                                            label="Testimonial Text"
                                            :errors="getErrors(`languages.${lang.code}.text`)">
                                            <Textarea class="w-full"
                                                      v-model="form.languages[lang.code].text"
                                                      :maxlength="1000"
                                                      :rows="6"/>
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
    sort_number: 0,
    languages: {}
})

const formSchema = createFormSchema(zod.object({}),
    {
        languages: languagesStore.languages.map(lang => lang.code),
        requiredLanguages: ['en'],
        languageSchema: zod.object({
            name: zod.string().nonempty('Name is required'),
            text: zod.string().nonempty('Testimonial text is required'),
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
            message: 'Fetching GPS testimonial information...'
        })

        if (props.record?.id) {
            const response = await window.axios.get(`api/gps_testimonials/${props.record.id}`)
            newData = response.data

            languagesStore.languages.forEach(lang => {
                if (!newData.languages[lang.code]) {
                    newData.languages[lang.code] = {
                        language_id: lang.id,
                        name: '',
                        text: '',
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
            name: '',
            text: '',
        }
    })
})
</script>

<style scoped>
</style>
