<template>
    <div :class="`w-1/4 h-48 p-3 ${live ? '' : 'bg-opacity-50 '}bg-secondary rounded-xl`" :style="`background-image:url('${category.img}')`">
        <div v-if="live">
            {{ category.name }}
        </div>
    </div>
</template>

<script>
export default {
    props: ["category", "live"]
};
</script>
