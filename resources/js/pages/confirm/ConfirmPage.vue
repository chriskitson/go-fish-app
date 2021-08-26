<template>
    <div class="w-full max-w-5xl mx-auto">
        <p>Thank you for your payment</p>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            venues: state => state.venues,
            live: state => state.live
        })
    },
    mounted() {

    },
    methods: { }
};
</script>
