<template>
    <div :class="`mb-4 w-full md:w-1/2 lg:w-1/4 h-48 p-3 ${live ? '' : 'bg-opacity-50 '}bg-grey-100 rounded-xl bg-cover`" :style="`background-image:url('${live ? venue.image : ''}')`">
        <div v-if="live">
            <a :href="`/venue/${venue.id}`">{{ venue.name }} - {{ venue.distanceDisplay }}</a>
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
