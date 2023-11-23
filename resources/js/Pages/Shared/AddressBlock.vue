<template>
    <InstanceDetails :details="details"
                     :input="input"
                     @update_details="updateAddressBlock"/>
</template>
<script setup>
import InstanceDetails from '@/Pages/Shared/InstanceDetails.vue';

const props = defineProps(['input', 'model', 'id']);
let details = [
    { type: 'text', placeholder: '125319', model: 'zip' },
    { type: 'text', placeholder: 'Russia', model: 'country' },
    { type: 'text', placeholder: 'Moscow', model: 'city' },
    { type: 'text', placeholder: 'L. Chaykinoy', model: 'street_01' },
    { type: 'text', placeholder: '12/2, 26', model: 'street_02' },
];

function updateAddressBlock(input) {
    let data = Object.assign({
        addressable_type: props.model,
        addressable_id: props.id,
    }, input);
	
    axios.post(route('update_address'), data).then(() => Event.emit('successfully_updated'));
}
</script>
