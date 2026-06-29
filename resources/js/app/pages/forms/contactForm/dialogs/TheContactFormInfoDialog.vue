<template>
    <BaseEditDialog
        :record="record"
        record-type="Contact Form"
        :with-submit="false"
        title="Contact Form"
        width="800px"
        :position="position"
        @close="emit('close')"
        ref="dialog">

        <template #content>
            <div class="mt-4 space-y-6">
                <!-- Contact Information -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-blue-50 px-6 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Contact Information</h3>
                    </div>
                    <dl class="divide-y divide-gray-200">
                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Name</dt>
                            <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.name }}</dd>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Phone</dt>
                            <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.phone_number }}</dd>
                        </div>
                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Email</dt>
                            <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.email }}</dd>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Industry</dt>
                            <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.industry }}</dd>
                        </div>
                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Number of Vehicles</dt>
                            <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.number_of_vehicles }}</dd>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Country</dt>
                            <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.country }}</dd>
                        </div>
                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Message</dt>
                            <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.message }}</dd>
                        </div>

                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Submission Date</dt>
                            <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ formatDateTime(record.created_at) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Details -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-blue-50 px-6 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Details</h3>
                    </div>
                    <dl class="divide-y divide-gray-200">
                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Status</dt>
                            <dd class="mt-1 sm:col-span-2 sm:mt-0">
                                <Tag v-if="record.status === 'Intake'" severity="secondary" value="Intake" />
                                <Tag v-else-if="record.status === 'Unqualified'" severity="danger" value="Unqualified" />
                                <Tag v-else-if="record.status === 'Qualified'" severity="info" value="Qualified" />
                                <Tag v-else-if="record.status === 'Converted'" severity="success" value="Converted" />
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Tracking -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-blue-50 px-6 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Tracking</h3>
                    </div>
                    <dl class="divide-y divide-gray-200">
                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">UTM Source</dt>
                            <dd class="mt-1 sm:col-span-2 sm:mt-0" :class="record.utm_source ? 'text-gray-700' : 'text-gray-400 italic'">
                                {{ record.utm_source || 'Not provided' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">UTM Campaign</dt>
                            <dd class="mt-1 sm:col-span-2 sm:mt-0" :class="record.utm_campaign ? 'text-gray-700' : 'text-gray-400 italic'">
                                {{ record.utm_campaign || 'Not provided' }}</dd>
                        </div>
                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">UTM Medium</dt>
                            <dd class="mt-1 sm:col-span-2 sm:mt-0" :class="record.utm_medium ? 'text-gray-700' : 'text-gray-400 italic'">
                                {{ record.utm_medium || 'Not provided' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">UTM Content</dt>
                            <dd class="mt-1 sm:col-span-2 sm:mt-0" :class="record.utm_content ? 'text-gray-700' : 'text-gray-400 italic'">
                                {{ record.utm_content || 'Not provided' }}</dd>
                        </div>
                        <div class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                            <dt class="font-semibold text-gray-800">Referrer</dt>
                            <dd class="mt-1 sm:col-span-2 sm:mt-0" :class="record.referrer ? 'text-gray-700' : 'text-gray-400 italic'">
                                {{ record.referrer || 'Not provided' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </template>
    </BaseEditDialog>
</template>

<script setup>
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";
import useAlerts from "kockatoos-admin-ui/composables/useAlerts.js";
import { ref, onMounted } from "vue";
import useConfirmDialog from "kockatoos-admin-ui/composables/useConfirmDialog.js";
import useEditDialog from "kockatoos-admin-ui/composables/useEditDialog.js";
import Tag from 'primevue/tag';

const props = defineProps({
    position: {
        type: String,
        default: 'middle',
    },
    record: Object
});

const emit = defineEmits(['close', 'submit']);
const {} = useConfirmDialog();

const dialog = ref();
const {} = useEditDialog(dialog);
const { alertError } = useAlerts();

async function markAsRead() {
    if (props.record && props.record.is_read === 0) {
        try {
            await window.axios.put(`api/contactForms/${props.record.id}/toggleRead`);
            emit('submit');
        } catch (error) {
            console.error('Error marking contact form as read:', error);
            alertError('Failed to mark contact form as read');
        }
    }
}

onMounted(() => {
    markAsRead();
});

function formatDateTime(date) {
    if (!date) return '';
    const formattedDate = new Date(date);
    const day = formattedDate.getDate();
    const month = formattedDate.getMonth() + 1;
    const year = formattedDate.getFullYear();
    const hours = formattedDate.getHours();
    const hoursString = hours < 10 ? '0' + hours : hours;
    const minutes = formattedDate.getMinutes();
    const minutesString = minutes < 10 ? '0' + minutes : minutes;

    return day + '/' + month + '/' + year + ' ' + hoursString + ':' + minutesString;
}
</script>
