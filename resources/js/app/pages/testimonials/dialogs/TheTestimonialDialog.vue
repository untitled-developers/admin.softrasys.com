<template>
  <BaseEditDialog
      form-id="testimonial-form"
      :record="record"
      record-type="Testimonial"
      endpoint="api/testimonials"
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
      <form id="testimonial-form" @submit.prevent="handleSubmit" class="flex flex-col gap-y-4">

        <BaseInputContainer
            label="Name"
            :errors="getErrors('name')"
            :show-errors="didSubmit">
          <InputText v-model="form.name"/>
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

import BaseRichEditor from "kockatoos-admin-ui/components/BaseRichEditor.vue";
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
  name: '',
  description: '',
  sort_number: 0,
})


const formSchema = createFormSchema(zod.object({
      name: zod.string().nonempty('Name is required'),
      description: zod.string().nonempty('Description is required'),
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
