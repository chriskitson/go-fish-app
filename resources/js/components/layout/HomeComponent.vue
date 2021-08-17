<template>
    <div class="w-full max-w-5xl mx-auto">
        <top-search-component
            :venueSearch="venueSearch"
            :date="dateSearch"
            @set="$emit('setLocation', $event)"
            @search="$emit('searchVenues', $event)"
        ></top-search-component>
        <banner-component></banner-component>
        <venue-list-component
            title="Fisheries near me"
            :venues="venues"
            :live="live"
            :userPosition="userPosition"
            @showLocation="$emit('showLocation', $event)"
        ></venue-list-component>
        <category-list-component
            title="Explore Northern Ireland"
            :categories="counties"
            :live="true"
            display="5"
        ></category-list-component>
        <category-list-component
            title="How do you GoFish?"
            :categories="types"
            :live="true"
            display="4"
        ></category-list-component>
    </div>
</template>

<script>
export default {
    props: ["venues", "live", "userPosition", "venueSearch", "dateSearch"],
    data: () => ({
        counties: [
            {
                id: 1,
                name: "County Antrim",
                img: "/images/river.jpg"
            },
            {
                id: 1,
                name: "County Fermanagh",
                img: "/images/river.jpg"
            },
            {
                id: 1,
                name: "County Armagh",
                img: "/images/river.jpg"
            },
            {
                id: 1,
                name: "County Down",
                img: "/images/river.jpg"
            },
            {
                id: 1,
                name: "Belfast",
                img: "/images/river.jpg"
            }
        ],
        types: [
            {
                id: 1,
                name: "Sea fishing",
                img: "/images/river.jpg"
            },
            {
                id: 1,
                name: "Trout",
                img: "/images/river.jpg"
            },
            {
                id: 1,
                name: "Salmon",
                img: "/images/river.jpg"
            },
            {
                id: 1,
                name: "Fly fishing",
                img: "/images/river.jpg"
            }
        ]
    })
};
</script>
