<template>
    <div :class="`mb-4 flex items-end w-full h-48 p-3 ${live ? '' : 'bg-opacity-50 '}bg-grey-200 rounded-xl bg-cover`" :style="`background-image:url('${live ? venue.image : ''}')`">
        <div v-if="live">
            <a :href="`/venue/${venue.id}`" class="text-xl font-bold text-white">{{ venue.name }} {{ venue.distanceDisplay ? ` - ${venue.distanceDisplay}` : '' }}</a>
        </div>
        <div class="flex items-center justify-center w-full h-full" v-if="!live">
            <spinner-component />
        </div>
    </div>
</template>

<script>
export default {
    props: ["venue", "live"]
};
</script>
