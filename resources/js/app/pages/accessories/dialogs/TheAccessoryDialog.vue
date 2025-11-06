<template>
    <BaseEditDialog
        form-id="accessory-form"
        :record="record"
        record-type="Accessory"
        endpoint="api/accessories"
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
            <form id="accessory-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">
                <div class="flex justify-center gap-x-4">
                    <div class="cursor-pointer">
                        <BaseInputContainer
                            label="Image*"
                            :errors="getErrors('image')"
                            :show-errors="didSubmit">
                            <div class="text-sm  mb-2 text-red-500">
                                Max Size: 2MB
                            </div>
                            <BaseSingleImageUploader
                                :image="record?.blob_url"
                                @change="handleImageChange"
                            />
                        </BaseInputContainer>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-y-4 gap-x-2">
                    <div class="col-span-12">
                        <BaseInputContainer
                            label="btn Href">
                            <InputText class="w-full" v-model="form.btn_href"/>
                        </BaseInputContainer>
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
                                            `languages.${lang.code}.name`,
                                            `languages.${lang.code}.btn_text`,
                                            `languages.${lang.code}.short_description`,
                                            `languages.${lang.code}.long_description`,
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
                                            label="Btn Text"
                                            :errors="getErrors(`languages.${lang.code}.btn_text`)">
                                            <InputText maxlength="120" v-model="form.languages[lang.code].btn_text"/>
                                        </BaseInputContainer>
                                        <BaseInputContainer
                                            label="Meta Description">
                                            <Textarea maxlength="120" v-model="form.languages[lang.code].meta_description"/>
                                        </BaseInputContainer>
                                        <BaseInputContainer
                                            label="Short Description">
                                            <BaseRichEditor
                                                place-holder="Enter Short Description"
                                                v-model="form.languages[lang.code].short_description"
                                                :language="lang.code"
                                                ref="editor"/>
                                        </BaseInputContainer>

                                        <BaseInputContainer
                                            label="Description">
                                            <BaseRichEditor
                                                place-holder="Enter Description"
                                                v-model="form.languages[lang.code].long_description"
                                                :language="lang.code"
                                                ref="editor"/>
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
import BaseSingleImageUploader from "kockatoos-admin-ui/components/BaseSingleImageUploader.vue";
import Textarea from "primevue/textarea";
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
    btn_href: '',
    image: null,
    languages: {}

})


const formSchema = createFormSchema(zod.object({
    }),
    {
        languages: languagesStore.languages.map(lang => lang.code),
        requiredLanguages: ['en'],
        languageSchema: zod.object({
            name: zod.string().nonempty('Name is required'),
            short_description: zod.string().nonempty('Short description is required'),
            long_description: zod.string().nonempty('Description is required')
        }),
        image: props.record ? zod.any() : zod.object({}, {message: 'Image is required'}),

    })

function handleImageChange(image) {
    form.value.image = image
}
function requestBodyMapper(data) {
    let newData = {...data}
    delete newData.image

    return {
        data: newData,
        image: form.value.image,

    }
}

async function recordMapper(data) {
    let newData = {...data}
    newData.languages = {}

    try {
        startDialogLoading({
            blockUI: true,
            message: 'Fetching Accessories information...'
        })

        if (props.record?.id) {
            const response = await window.axios.get(`api/accessories/${props.record.id}`)
            newData = response.data

            // Ensure all languages exist in the languages object
            languagesStore.languages.forEach(lang => {
                if (!newData.languages[lang.code]) {
                    newData.languages[lang.code] = {
                        language_id: lang.id,
                        name: '',
                        short_description: '',
                        long_description: '',
                        meta_description: ''
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
            short_description: '',
            long_description: '',
            meta_description: ''
        }
    })
})
</script>

<style scoped>

</style>
