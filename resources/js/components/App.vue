<template>
    <div id="app">
        <header-component></header-component>
        <h1 class="text-sm">Hello World</h1>
        {{venues.length}}
        <footer-component></footer-component>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            venues: state => state.venues
        })
    }
};
</script>
