<template>
    <div>
        <div class="star-rating">
            <span v-for="n in max" :key="`rating-on-${n}`">&star;</span>
            <div
                class="star-rating__current"
                :style="{ width: getRating + '%' }"
            >
                <span v-for="n in max" :key="`rating-off-${n}`">&starf;</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["max", "current"],
    computed: {
        getRating: function() {
            return (this.current / this.max) * 100;
        }
    }
};
</script>
