<template>
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-4 gap-6 mt-10 mb-20">
            <div>
                &nbsp;
            </div>
            <div class="col-span-3">
                <search-result-list-component
                    :results="venueSearchResults"
                    title="Search Results"
                ></search-result-list-component>
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
    }
};
</script>
