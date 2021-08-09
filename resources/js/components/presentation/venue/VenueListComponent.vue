<template>
    <div
        class="w-full max-w-5xl"
    >
        <h2 class="mt-20">{{ title }}</h2>
        <div class="flex items-center justify-between w-full mx-auto py-50">
            <venue-item-component
                v-for="(venue, i) in venues"
                :key="i"
                :live="live"
                :venue="venue"
            ></venue-item-component>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "venues", "live"]
};
</script>
