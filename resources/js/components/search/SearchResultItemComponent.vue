<template>
    <div class="flex flex-col w-full p-2 rounded-md bg-light">
        <a :href="`/venue/${result.id}`">{{ result.name }} - {{ result.distanceDisplay }}</a>
    </div>
</template>

<script>
export default {
    props: ["result"]
};
</script>
