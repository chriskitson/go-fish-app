<template>
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
            <div>
              &nbsp;
            </div>
            <div class="col-span-2">
              <h2>Search results</h2>
              <div v-if="venueSearchResults.length === 0">
                There are no venues that match your search
              </div>
              <div v-if="venueSearchResults.length > 0">
                {{ venueSearchResults.length }}
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
            venues: state => state.venues,
            live: state => state.live,
            venueDetail: state => state.venueDetail,
            venueSearchResults: state => state.venueSearchResults
        })
    },
    mounted() {

    },
    methods: {

    }
};
</script>
