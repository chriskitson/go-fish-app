<template>
    <div class="w-full max-w-5xl mx-auto">
      Log in the boy yee!
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            venues: state => state.venues,
            live: state => state.live,
            userPosition: state => state.userPosition,
            locationSearch: state => state.locationSearch,
            venueDetail: state => state.venueDetail
        })
    },
    methods: {

    }
};
</script>
