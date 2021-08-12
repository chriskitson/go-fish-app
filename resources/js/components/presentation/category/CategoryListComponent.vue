<template>
    <div class="w-full max-w-5xl mt-10">
        <h2 class="flex items-center mb-2 text-xl font-semibold">
            {{ title }}
        </h2>
        <div
            class="flex items-center justify-between w-full mx-auto space-x-4 py-50"
            v-if="live"
        >
            <category-item-component
                v-for="(cat, i) in categories"
                :key="i"
                :live="live"
                :category="cat"
            ></category-item-component>
            <category-item-component
                v-for="index in categories.length < 4 ? 4 - categories.length : 0"
                :key="index"
                :live="false"
            ></category-item-component>
        </div>
        <div
            class="flex items-center justify-between w-full mx-auto space-x-4 py-50"
            v-if="!live"
        >
            <category-item-component :live="live"></category-item-component>
            <category-item-component :live="live"></category-item-component>
            <category-item-component :live="live"></category-item-component>
            <category-item-component :live="live"></category-item-component>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "categories", "live" ]
};
</script>
