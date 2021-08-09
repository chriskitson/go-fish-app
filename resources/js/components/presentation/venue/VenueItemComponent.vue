<template>
    <div class="py-10">
        {{ venue.name }}
    </div>
</template>

<script>
export default {
    props: ["venue", "live"]
};
</script>