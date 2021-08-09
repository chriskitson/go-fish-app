<template>
    <main class="w-full" id="app">
        <header-component></header-component>
        <home-component :venues="venues" :live="live"></home-component>
        <footer-component></footer-component>
    </main>
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
        this.$store.dispatch("BOOTSTRAP_DATA_FETCH");
    }
};
</script>
