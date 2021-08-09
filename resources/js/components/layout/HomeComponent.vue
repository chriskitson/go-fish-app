<template>
    <div
        class="flex items-center justify-between w-full max-w-5xl px-8 mx-auto"
    >
        <venue-list-component
            title="Fisheries near me"
            :venues="venues"
            :live="live"
        ></venue-list-component>
    </div>
</template>

<script>
export default {
    props: ["venues", "live"]
};
</script>
