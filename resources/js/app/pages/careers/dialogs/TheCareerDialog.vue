<template>
    <BaseEditDialog
        form-id="career-form"
        :record="record"
        record-type="Career"
        endpoint="api/careers"
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
            <form id="career-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">

                <BaseInputContainer
                    label="Title"
                    :errors="getErrors('title')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.title"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Type"
                    :errors="getErrors('type')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.type"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Short Description"
                    :errors="getErrors('short_description')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.short_description"/>
                </BaseInputContainer>

                <BaseInputContainer
                    label="Sort Number"
                    :errors="getErrors('sort_number')"
                    :show-errors="didSubmit">
                    <InputNumber class="w-full" v-model="form.sort_number"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Description"
                    :errors="getErrors('description')"
                    :show-errors="didSubmit">
                    <BaseRichEditor
                        place-holder="Description"
                        v-model="form.description"
                        ref="editor"/>
                </BaseInputContainer>
            </form>
        </template>
    </BaseEditDialog>
</template>

<script setup>
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import BaseInputContainer from "kockatoos-admin-ui/components/BaseInputContainer.vue";
import {ref} from "vue";
import * as zod from "zod";
import useCreateFormSchema from "kockatoos-admin-ui/composables/useCreateFormSchema.js";
import useEditDialog from "kockatoos-admin-ui/composables/useEditDialog.js";
import BaseRichEditor from "kockatoos-admin-ui/components/BaseRichEditor.vue";

const props = defineProps({
    record: Object,

})
const emit = defineEmits(['close', 'submit', 'next-record', 'previous-record'])
const dialog = ref(null)
const {} = useEditDialog(dialog)
const {createFormSchema} = useCreateFormSchema({props})

const form = ref({
    title: '',
    type: '',
    short_description: '',
    description: '',
    sort_number: 0,

})


const formSchema = createFormSchema(zod.object({
        title: zod.string().nonempty('Title is required'),
        short_description: zod.string().nonempty('Short description is required'),
        type: zod.string().nonempty('Type is required'),
    })
)


function requestBodyMapper(data) {
    let newData = {...data}

    return {
        data: newData,

    }
}
</script>

<style scoped>

</style>
