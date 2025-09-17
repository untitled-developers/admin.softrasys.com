<template>
    <BaseEditDialog
        form-id="career-form"
        :record="record"
        record-type="Career"
        endpoint="api/careers"
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
            <form id="career-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">
                <div class="grid grid-cols-12 gap-y-4 gap-x-2">

                    <div class="col-span-12">
                        <BaseInputContainer
                            label="Type">
                            <InputText v-model="form.type"/>
                        </BaseInputContainer>

                    </div>
                </div>

                <div class="col-span-12">
                    <BaseInputContainer
                        label="Sort Number">
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
                                            `languages.${lang.code}.job_title`,
                                            `languages.${lang.code}.short_description`,
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
                                        :errors="getErrors(`languages.${lang.code}.job_title`)">
                                        <InputText maxlength="120" v-model="form.languages[lang.code].job_title"/>
                                    </BaseInputContainer>
                                    <BaseInputContainer
                                        :show-errors="didSubmit"
                                        label="Short Description"
                                        :errors="getErrors(`languages.${lang.code}.short_description`)">
                                        <InputText maxlength="120"
                                                   v-model="form.languages[lang.code].short_description"/>
                                    </BaseInputContainer>

                                    <BaseInputContainer
                                        label="Description">

                                        <BaseRichEditor
                                            place-holder="Enter Article Information"
                                            v-model="form.languages[lang.code].job_description"
                                            :language="lang.code"
                                            ref="editor"/>
                                    </BaseInputContainer>
                                </div>
                            </TabPanel>
                        </TabPanels>
                    </Tabs>
                </div>
            </form>
        </template>
    </BaseEditDialog>
</template>

<script setup>
import Tabs from "primevue/tabs";
import TabList from "primevue/tablist";
import Tab from "primevue/tab";
import TabPanel from "primevue/tabpanel";
import TabPanels from "primevue/tabpanels";
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import BaseInputContainer from "kockatoos-admin-ui/components/BaseInputContainer.vue";
import BaseDialogTabLabel from "kockatoos-admin-ui/components/BaseDialogTabLabel.vue";
import {ref, onBeforeMount} from "vue";
import * as zod from "zod";
import useCreateFormSchema from "kockatoos-admin-ui/composables/useCreateFormSchema.js";
import useEditDialog from "kockatoos-admin-ui/composables/useEditDialog.js";
import BaseRichEditor from "kockatoos-admin-ui/components/BaseRichEditor.vue";
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
    type: '',
    sort_number: 0,
    languages: {}

})


const formSchema = createFormSchema(zod.object({
        type: zod.string().nonempty('Type is required'),
    }),
    {
        languages: languagesStore.languages.map(lang => lang.code),
        requiredLanguages: ['en'],
        languageSchema: zod.object({
            job_title: zod.string().nonempty('Title is required'),
            short_description: zod.string().nonempty('Short description is required'),
            job_description: zod.string().nonempty('Description is required')
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
            message: 'Fetching Careers information...'
        })

        if (props.record?.id) {
            const response = await window.axios.get(`api/careers/${props.record.id}`)
            newData = response.data

            // Ensure all languages exist in the languages object
            languagesStore.languages.forEach(lang => {
                if (!newData.languages[lang.code]) {
                    newData.languages[lang.code] = {
                        language_id: lang.id,
                        job_title: '',
                        short_description: '',
                        job_description: ''
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
            job_title: '',
            short_description: '',
            job_description: ''
        }
    })
})
</script>

<style scoped>

</style>
