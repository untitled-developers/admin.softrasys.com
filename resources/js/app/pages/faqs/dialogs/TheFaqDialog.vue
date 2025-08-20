<template>
    <BaseEditDialog
        form-id="faq-form"
        :record="record"
        record-type="Faq"
        endpoint="api/faqs"
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
            <form id="faq-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">

                <BaseInputContainer
                    label="Question"
                    :errors="getErrors('question')"
                    :show-errors="didSubmit">
                    <InputText v-model="form.question"/>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Answer"
                    :errors="getErrors('answer')"
                    :show-errors="didSubmit">
                   <Textarea
                       class="w-full"
                       v-model="form.answer"
                       :maxlength="1000"
                       :rows="5"
                   ></Textarea>
                    <div class="text-right text-sm text-gray-500">
                        {{ 1000 - form.answer.length }} characters remaining
                    </div>
                </BaseInputContainer>
                <BaseInputContainer
                    label="Sort Number"
                    :errors="getErrors('sort_number')"
                    :show-errors="didSubmit">
                    <InputNumber class="w-full" v-model="form.sort_number"/>
                </BaseInputContainer>

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

const form = ref({
    question: '',
    answer: '',
    sort_number: 0,
})


const formSchema = createFormSchema(zod.object({
    question: zod.string().nonempty('Question is required'),
    answer: zod.string().nonempty('Answer is required'),
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
