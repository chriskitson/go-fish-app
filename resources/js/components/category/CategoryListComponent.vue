<template>
    <div class="w-full max-w-5xl mt-10">
        <h2 class="flex items-center mb-2 text-xl font-semibold">
            {{ title }}
        </h2>
        <div
            :class="`grid w-full grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-${display}`"
            v-if="live"
        >
            <category-item-component
                v-for="(cat, i) in categories"
                :key="`home-cat-${i}`"
                :live="live"
                :category="cat"
                :display="display"
            ></category-item-component>
            <category-item-component
                v-for="index in categories.length < display ? display - categories.length : 0"
                :key="index"
                :live="false"
                :display="display"
            ></category-item-component>
        </div>
        <div
            :class="`grid w-full grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-${display}`"
            v-if="!live"
        >
            <category-item-component :live="live" :display="display"></category-item-component>
            <category-item-component :live="live" :display="display"></category-item-component>
            <category-item-component :live="live" :display="display"></category-item-component>
            <category-item-component :live="live" :display="display"></category-item-component>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "categories", "live", "display" ]
};
</script>
