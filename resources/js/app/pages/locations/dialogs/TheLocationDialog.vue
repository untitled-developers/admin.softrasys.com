<template>
    <BaseEditDialog
        form-id="location-form"
        :record="record"
        record-type="Location"
        endpoint="api/locations"
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
            <form id="location-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">
                <div class="grid grid-cols-12 gap-y-4 gap-x-2">

                    <div class="col-span-12">
                        <BaseInputContainer
                            label="Email"
                            :errors="getErrors('email')"
                            :show-errors="didSubmit">
                            <InputText v-model="form.email"/>
                        </BaseInputContainer>
                    </div>
                    <div class="col-span-12">
                        <BaseInputContainer
                            label="Phone Number*"
                            :errors="getErrors('phone_number')"
                            :show-errors="didSubmit">
                            <InputText v-model="form.phone_number"/>
                        </BaseInputContainer>
                    </div>
                    <div class="col-span-12">
                        <BaseInputContainer
                            label="Fax Number"
                            :errors="getErrors('fax_number')"
                            :show-errors="didSubmit">
                            <InputText v-model="form.fax_number"/>
                        </BaseInputContainer>
                    </div>
                    <div class="col-span-12">
                        <BaseInputContainer
                            label="Support Number"
                            :errors="getErrors('support_number')"
                            :show-errors="didSubmit">
                            <InputText v-model="form.support_number"/>
                        </BaseInputContainer>
                    </div>
                    <div class="col-span-12">
                        <BaseInputContainer
                            label="Sort Number">
                            <InputNumber class="w-full" v-model="form.sort_number"/>
                        </BaseInputContainer>
                    </div>
                    <div class="col-span-12">
                        <BaseInputContainer
                            label="Map">
                            <BaseLocationInput
                                @change="handleLocationUpdate"
                                :latitude="getLatitude()"
                                :longitude="getLongitude()"
                                :api-key="mapAPIKey"
                                class="min-h-[250px]"
                            />
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
                                            `languages.${lang.code}.address`,
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
                                            <InputText v-model="form.languages[lang.code].name"/>
                                        </BaseInputContainer>
                                        <BaseInputContainer
                                            :show-errors="didSubmit"
                                            label="Address"
                                            :errors="getErrors(`languages.${lang.code}.address`)">
                                            <InputText v-model="form.languages[lang.code].address"/>
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
import BaseLocationInput from "kockatoos-admin-ui/components/BaseLocationInput.vue";
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import BaseInputContainer from "kockatoos-admin-ui/components/BaseInputContainer.vue";
import BaseDialogTabLabel from "kockatoos-admin-ui/components/BaseDialogTabLabel.vue";
import {ref, onBeforeMount} from "vue";
import * as zod from "zod";
import useCreateFormSchema from "kockatoos-admin-ui/composables/useCreateFormSchema.js";
import useEditDialog from "kockatoos-admin-ui/composables/useEditDialog.js";
import {useLanguagesStore} from "kockatoos-admin-ui/stores/LanguagesStore.js";

const props = defineProps({
    record: Object,

})
const emit = defineEmits(['close', 'submit', 'next-record', 'previous-record'])
const dialog = ref(null)
const {startDialogLoading, stopDialogLoading} = useEditDialog(dialog)
const languagesStore = useLanguagesStore()
const {createFormSchema} = useCreateFormSchema({props})
const mapAPIKey = ref('AIzaSyCncIBn6fIbklWaqhaNtVAMJnIUDivg1As')
const form = ref({
    email: '',
    phone_number: '',
    fax_number: '',
    support_number: '',
    sort_number: 0,
    latitude: null,
    longitude: null,
    languages: {}
})


const formSchema = createFormSchema(zod.object({
        phone_number: zod.string().nonempty('Phone number is required'),
    }),
    {
        languages: languagesStore.languages.map(lang => lang.code),
        requiredLanguages: ['en'],
        languageSchema: zod.object({
            name: zod.string().nonempty('Name is required'),
            address: zod.string().nonempty('Address is required'),
        }),
    })

function handleLocationUpdate(location) {
    form.value.latitude = location.latitude
    form.value.longitude = location.longitude
}

function getLongitude() {
    return parseFloat(form.value.longitude)
}

function getLatitude() {
    return parseFloat(form.value.latitude)
}

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
            message: 'Fetching location information...'
        })

        if (props.record?.id) {
            const response = await window.axios.get(`api/locations/${props.record.id}`)
            newData = response.data

            // Ensure all languages exist in the languages object
            languagesStore.languages.forEach(lang => {
                if (!newData.languages[lang.code]) {
                    newData.languages[lang.code] = {
                        language_id: lang.id,
                        name: '',
                        address: '',
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
            address: '',
        }
    })
})
</script>

<style scoped>

</style>
