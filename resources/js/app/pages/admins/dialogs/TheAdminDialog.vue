<template>
    <BaseEditDialog form-id="admin-form"
                    :record="record"
                    record-type="Admin"
                    endpoint="api/admins"
                    :record-mapper="recordMapper"
                    v-model:form="form"
                    v-model:form-schema="formSchema"
                    @submit="emit('submit')"
                    @next-record="emit('next-record', record)"
                    @previous-record="emit('previous-record',record)"
                    @close="emit('close')">

        <template #content="{handleSubmit, getErrors, didSubmit}">
            <form id="admin-form"
                  @submit.prevent="handleSubmit"
                  class="flex flex-col gap-y-4">
                <BaseInputContainer label="Username"
                                    :errors="getErrors('username')"
                                    :show-errors="didSubmit">
                    <InputText v-model="form.username"/>
                </BaseInputContainer>
                <BaseInputContainer label="Name">
                    <InputText v-model="form.name"/>
                </BaseInputContainer>
                <BaseInputContainer label="Phone">
                    <InputText v-model="form.phone"/>
                </BaseInputContainer>
                <BaseInputContainer label="Password"
                                    :errors="getErrors('password')"
                                    :show-errors="didSubmit">
                    <InputText v-model="form.password" type="password"/>
                </BaseInputContainer>
            </form>
        </template>
    </BaseEditDialog>
</template>

<script setup>
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";
import {InputText} from "primevue";
import BaseInputContainer from "kockatoos-admin-ui/components/BaseInputContainer.vue";
import {ref} from "vue";
import * as zod from "zod";
import useCreateFormSchema from "kockatoos-admin-ui/composables/useCreateFormSchema.js";

const props = defineProps({
    record: Object
})
const {createFormSchema} = useCreateFormSchema({props})
const emit = defineEmits(['close', 'submit', 'next-record', 'previous-record'])
const form = ref({
    name: '',
    username: '',
    phone: '',
    password: '',
    // Roles are hardcoded for now since we usually only have super admins
    roles: [1]
})

let formSchema = createFormSchema(zod.object({
    username: zod.string().nonempty('Username is required'),
    password: zod.string().nonempty('Password is required').min(6, 'Password must be at least 6 characters')
}))

// Roles are hardcoded for now since we usually only have super admins
function recordMapper(record) {
    return {
        ...record,
        roles: [1]
    }
}
</script>
