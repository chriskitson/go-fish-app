<template>
    <div class="w-full max-w-5xl mx-auto">
        <top-search-component
            :venueSearch="venueSearch"
            :date="dateSearch"
            @set="$emit('setLocation', $event)"
            @search="$emit('searchVenues', $event)"
        ></top-search-component>
        Bananas!!
    </div>
</template>

<script>
export default {
    props: ["venueSearch", "dateSearch"],
};
</script>
