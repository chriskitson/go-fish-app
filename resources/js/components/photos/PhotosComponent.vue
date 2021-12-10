<template>
    <div
        class="pt-8 mb-8 border-t border-grey-100"
    >
        <h3 class="mb-4 text-lg font-semibold">
            Photos of {{ name }}:
        </h3>
        <div class="grid grid-cols-3 gap-2">
            <img
                class="rounded-md"
                v-for="(img, i) in photos"
                :src="img.url"
                :key="`venue-image-${i}`"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: ["name", "photos"]
};
</script>
