<template>
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-4 gap-6 px-4 mt-10 mb-20">
            <div>
                &nbsp;
            </div>
            <div class="col-span-3">
                <div v-for="venue in venueCategory" :key="`venue-${venue.id}`">
                    <a :href="`/venue/${venue.id}`" class="text-red-200">{{ venue.name }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            live: state => state.live,
            venueCategory: state => state.venueCategory
        })
    }
};
</script>
