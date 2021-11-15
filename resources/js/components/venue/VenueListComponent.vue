<template>
    <div class="w-full mt-10">
        <h2 class="flex items-center mb-2 text-xl font-semibold">
            {{ title }}
            <span
                v-if="userPosition && userPosition.town !== ''"
                class="flex items-center ml-2"
            >
                <span class="hidden md:block"> - {{ userPosition.town }}</span>
                <a href="#" v-on:click.self.prevent="$emit('showLocation', true)" class="flex items-center ml-4 text-sm text-red-200 md:ml-10"
                    ><icon name="location-marker" class="w-4 h-4 mr-2 text-red-200" /> Update my
                    location</a
                >
            </span>
        </h2>
        <div
            :class="`grid w-full grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4`"
            v-if="live && venues"
        >
            <venue-item-component
                v-for="(venue, i) in venues"
                :key="i"
                :live="live"
                :venue="venue"
            ></venue-item-component>
            <venue-item-component
                v-for="index in venues.length < 4 ? 4 - venues.length : 0"
                :key="index"
                :live="false"
            ></venue-item-component>
        </div>
        <div
            :class="`grid w-full grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4`"
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
    props: ["title", "venues", "live", "userPosition"]
};
</script>
