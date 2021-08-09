<template>
    <div :class="`w-1/4 h-48 p-3 ${live ? '' : 'bg-opacity-50 '}bg-secondary rounded-xl`">
        <div v-if="live">
            {{ venue.name }}
        </div>
    </div>
</template>

<script>
export default {
    props: ["venue", "live"]
};
</script>
