<template>
    <div class="w-full max-w-5xl mt-10">
        <h2 class="mb-2 text-xl font-semibold">{{ title }}</h2>
        <div
            class="flex items-center justify-between w-full mx-auto space-x-4 py-50"
            v-if="live"
        >
            <venue-item-component
                v-for="(venue, i) in venues"
                :key="i"
                :live="live"
                :venue="venue"
            ></venue-item-component>
            <venue-item-component
                v-for="index in (venues.length < 4 ? 4 - venues.length : 0)"
                :key="index"
                :live="false"
            ></venue-item-component>
        </div>
        <div
            class="flex items-center justify-between w-full mx-auto space-x-4 py-50"
            v-if="!live"
        >
            <venue-item-component :live="live"></venue-item-component>
            <venue-item-component :live="live"></venue-item-component>
            <venue-item-component :live="live"></venue-item-component>
            <venue-item-component :live="live"></venue-item-component>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "venues", "live"]
};
</script>
