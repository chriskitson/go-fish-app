<template>
    <div class="w-full max-w-5xl mx-auto">
        <top-search-component></top-search-component>
        <banner-component></banner-component>
        <venue-list-component
            title="Fisheries near me"
            :venues="venues"
            :live="live"
            :userPosition="userPosition"
            @showLocation="$emit('showLocation', $event)"
        ></venue-list-component>
        <venue-list-component
            title="Best fisheries near me"
            :venues="venues"
            :live="live"
            :userPosition="userPosition"
            @showLocation="$emit('showLocation', $event)"
        ></venue-list-component>
    </div>
</template>

<script>
export default {
    props: ["venues", "live", "userPosition"]
};
</script>
