<template>
    <BaseEditDialog
        form-id="faq-form"
        :record="record"
        record-type="Faq"
        endpoint="api/faqs"
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
            <form id="faq-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">
                <div class="grid grid-cols-12 gap-y-4 gap-x-2">
                    <div class="col-span-12">
                        <BaseInputContainer
                            label="Sort Number"
                            :errors="getErrors('sort_number')"
                            :show-errors="didSubmit">
                            <InputNumber class="w-full" v-model="form.sort_number"/>
                        </BaseInputContainer>
                    </div>


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
                                            `languages.${lang.code}.question`,
                                            `languages.${lang.code}.description`,
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
                                        label="Question"
                                        :errors="getErrors(`languages.${lang.code}.question`)">
                                        <InputText maxlength="120" v-model="form.languages[lang.code].question"/>
                                    </BaseInputContainer>

                                    <BaseInputContainer
                                        label="Answer"
                                        :errors="getErrors('answer')"
                                        :show-errors="didSubmit"
                                    >
                                        <Textarea
                                            class="w-full"
                                            v-model="form.languages[lang.code].answer"
                                            :maxlength="1000"
                                            :rows="5"
                                        />
                                        <div class="text-right text-sm text-gray-500">
                                            {{ 1000 - form.languages[lang.code].answer.length }} characters remaining
                                        </div>
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
            question: zod.string().nonempty('Question is required'),
            answer: zod.string().nonempty('Answer is required'),
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
            message: 'Fetching Faqs information...'
        })

        if (props.record?.id) {
            const response = await window.axios.get(`api/faqs/${props.record.id}`)
            newData = response.data

            // Ensure all languages exist in the languages object
            languagesStore.languages.forEach(lang => {
                if (!newData.languages[lang.code]) {
                    newData.languages[lang.code] = {
                        language_id: lang.id,
                        question: '',
                        answer: '',
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
            question: '',
            answer: '',
        }
    })
})
</script>

<style scoped>

</style>
