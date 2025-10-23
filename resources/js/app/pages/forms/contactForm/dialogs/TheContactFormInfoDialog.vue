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
            <div class="mt-4 border-t border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <dl class="divide-y divide-gray-200">
                    <div
                        class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Name</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.name }}</dd>
                    </div>
                    <div
                        class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Phone</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.phone_number }}</dd>
                    </div>
                    <div
                        class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Email</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.email }}</dd>
                    </div>
                    <div
                        class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Industry</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.industry }}</dd>
                    </div>
                    <div
                        class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Number of Vehicles</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.number_of_vehicles }}</dd>
                    </div>
                    <div
                        class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Country</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.country }}</dd>
                    </div>
                    <div
                        class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Message</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">{{ record.message }}</dd>
                    </div>
                    <div
                        class="bg-white px-6 py-4 hover:bg-gray-50 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Source</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">
                            {{ record.source}}
                        </dd>
                    </div>
                    <div
                        class="bg-gray-50 px-6 py-4 hover:bg-gray-100 transition-colors duration-150 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-4">
                        <dt class="font-semibold text-gray-800">Submission Date</dt>
                        <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0">
                            {{ formatDateTime(record.created_at) }}
                        </dd>
                    </div>
                </dl>
            </div>
        </template>
    </BaseEditDialog>
</template>

<script setup>
import BaseEditDialog from "kockatoos-admin-ui/components/BaseEditDialog.vue";

const props = defineProps({
    position: {
        type: String,
        default: 'middle',
    },
    record: Object
});

const emit = defineEmits(['close']);

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
