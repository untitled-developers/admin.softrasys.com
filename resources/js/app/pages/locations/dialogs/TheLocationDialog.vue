<template>
    <BaseEditDialog
        form-id="location-form"
        :record="record"
        record-type="Location"
        endpoint="api/locations"
        :request-body-mapper="requestBodyMapper"
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
                <BaseInputContainer
                    label="Name*"
                    :errors="getErrors('name')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.name"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Email"
                    :errors="getErrors('email')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.email"/>
                </BaseInputContainer>

                <BaseInputContainer
                    label="Phone Number*"
                    :errors="getErrors('phone_number')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.phone_number"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Fax Number"
                    :errors="getErrors('fax_number')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.fax_number"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Support Number"
                    :errors="getErrors('support_number')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.support_number"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Address*"
                    :errors="getErrors('address')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.address"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Location Link*"
                    :errors="getErrors('location_link')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.location_link"/>
                </BaseInputContainer>

                <BaseInputContainer
                    label="Sort Number"
                >
                    <InputNumber class="w-full" v-model="form.sort_number"/>
                </BaseInputContainer>
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

            </form>
        </template>
    </BaseEditDialog>
</template>

<script setup>
import BaseLocationInput from "kockatoos-admin-ui/components/BaseLocationInput.vue";
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import BaseInputContainer from "kockatoos-admin-ui/components/BaseInputContainer.vue";
import {ref} from "vue";
import * as zod from "zod";
import useCreateFormSchema from "kockatoos-admin-ui/composables/useCreateFormSchema.js";
import useEditDialog from "kockatoos-admin-ui/composables/useEditDialog.js";

const props = defineProps({
    record: Object,

})
const emit = defineEmits(['close', 'submit', 'next-record', 'previous-record'])
const dialog = ref(null)
const {} = useEditDialog(dialog)
const {createFormSchema} = useCreateFormSchema({props})
const mapAPIKey = ref('AIzaSyCncIBn6fIbklWaqhaNtVAMJnIUDivg1As')
const form = ref({
    name: '',
    email: '',
    phone_number: '',
    fax_number: '',
    support_number: '',
    address: '',
    location_link: '',
    sort_number: 0,
    image: null,
    latitude: null,
    longitude: null,

})


const formSchema = createFormSchema(zod.object({
        name: zod.string().nonempty('Title is required'),
        phone_number: zod.string().nonempty('Phone number is required'),
        address: zod.string().nonempty('Address is required'),
        location_link: zod.string().url('Link must be a valid URL').nonempty('Link is required'),

    })
)
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
</script>

<style scoped>

</style>
