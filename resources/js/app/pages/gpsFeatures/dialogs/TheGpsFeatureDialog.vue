<template>
    <BaseEditDialog
        form-id="gps-feature-form"
        :record="record"
        record-type="GPS Feature"
        endpoint="api/gps_features"
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
            <form id="gps-feature-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">
                <div class="flex justify-center gap-x-4">
                    <div class="cursor-pointer">
                        <BaseInputContainer
                            label="Icon*"
                            :errors="getErrors('image')"
                            :show-errors="didSubmit">
                            <div class="text-sm mb-2 text-red-500">
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
                                            label="Title"
                                            :errors="getErrors(`languages.${lang.code}.title`)">
                                            <InputText maxlength="120" v-model="form.languages[lang.code].title"/>
                                        </BaseInputContainer>

                                        <BaseInputContainer
                                            :show-errors="didSubmit"
                                            label="Description"
                                            :errors="getErrors(`languages.${lang.code}.description`)">
                                            <Textarea class="w-full"
                                                      v-model="form.languages[lang.code].description"
                                                      :maxlength="500"
                                                      :rows="4"/>
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
import BaseSingleImageUploader from "kockatoos-admin-ui/components/BaseSingleImageUploader.vue";

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
    image: null,
    languages: {}
})

const formSchema = createFormSchema(zod.object({}),
    {
        languages: languagesStore.languages.map(lang => lang.code),
        requiredLanguages: ['en'],
        languageSchema: zod.object({
            title: zod.string().nonempty('Title is required'),
            description: zod.string().nonempty('Description is required'),
        }),
        image: props.record ? zod.any() : zod.object({}, {message: 'Icon is required'}),
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
            message: 'Fetching GPS feature information...'
        })

        if (props.record?.id) {
            const response = await window.axios.get(`api/gps_features/${props.record.id}`)
            newData = response.data

            languagesStore.languages.forEach(lang => {
                if (!newData.languages[lang.code]) {
                    newData.languages[lang.code] = {
                        language_id: lang.id,
                        title: '',
                        description: '',
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
            description: '',
        }
    })
})
</script>

<style scoped>
</style>
