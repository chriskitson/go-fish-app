<template>
    <div class="flex flex-col w-full p-4 text-white rounded-md bg-secondary">
        <a :href="`/venue/${result.id}`">{{ result.name }} - {{ result.distanceDisplay }}</a>
        <span class="px-3 py-1 mt-2 text-white border border-white rounded-full" v-if="result.tickets.length > 0">There {{ result.tickets.length ===  1 ? `is ${result.tickets.length} type` : `are ${result.tickets.length} types` }} of tickets available for {{result.name}} on this date.</span>
        <span class="px-3 py-1 mt-2 text-white border border-white rounded-full" v-if="result.tickets.length === 0">There are no tickets available for {{result.name}} on this date.</span>
    </div>
</template>

<script>
export default {
    props: ["result"]
};
</script>
