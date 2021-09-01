<template>
    <div class="w-full max-w-5xl mx-auto">
        <h1 class="my-16 text-xl font-semibold">Thank you for your payment</h1>
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
    mounted() {},
    methods: {}
};
</script>
