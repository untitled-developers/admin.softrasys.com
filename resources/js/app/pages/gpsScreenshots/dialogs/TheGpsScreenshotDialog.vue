<template>
    <BaseEditDialog
        form-id="gps-screenshot-form"
        :record="record"
        record-type="GPS Screenshot"
        endpoint="api/gps_screenshots"
        :request-body-mapper="requestBodyMapper"
        :record-mapper="recordMapper"
        v-model:form="form"
        v-model:form-schema="formSchema"
        @submit="emit('submit')"
        @next-record="emit('next-record', record)"
        @previous-record="emit('previous-record', record)"
        @close="emit('close')"
        ref="dialog"
        width="700px"
    >
        <template #content="{getErrors, handleSubmit, didSubmit}">
            <form id="gps-screenshot-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">
                <div class="flex justify-center gap-x-4">
                    <div class="cursor-pointer">
                        <BaseInputContainer
                            label="Screenshot*"
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
                </div>
            </form>
        </template>
    </BaseEditDialog>
</template>

<script setup>
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";
import InputNumber from "primevue/inputnumber";
import BaseInputContainer from "kockatoos-admin-ui/components/BaseInputContainer.vue";
import {ref} from "vue";
import * as zod from "zod";
import useCreateFormSchema from "kockatoos-admin-ui/composables/useCreateFormSchema.js";
import useEditDialog from "kockatoos-admin-ui/composables/useEditDialog.js";
import BaseSingleImageUploader from "kockatoos-admin-ui/components/BaseSingleImageUploader.vue";

const props = defineProps({
    record: Object,
})
const emit = defineEmits(['close', 'submit', 'next-record', 'previous-record'])
const dialog = ref(null)
const {startDialogLoading, stopDialogLoading} = useEditDialog(dialog)
const {createFormSchema} = useCreateFormSchema({props})

const form = ref({
    sort_number: 0,
    image: null,
})

const formSchema = createFormSchema(zod.object({}),
    {
        image: props.record ? zod.any() : zod.object({}, {message: 'Screenshot is required'}),
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

    try {
        startDialogLoading({
            blockUI: true,
            message: 'Fetching GPS screenshot information...'
        })

        if (props.record?.id) {
            const response = await window.axios.get(`api/gps_screenshots/${props.record.id}`)
            newData = response.data
        }

        return newData
    } catch (error) {
        console.error(error)
        return newData
    } finally {
        stopDialogLoading()
    }
}
</script>

<style scoped>
</style>
