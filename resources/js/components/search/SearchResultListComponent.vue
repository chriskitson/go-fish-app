<template>
    <div class="w-full max-w-5xl mb-10">
        <h2 class="flex items-center mb-4 text-xl font-semibold">
            {{ title }}
        </h2>
        <div
            class="flex flex-wrap items-center w-full space-y-4 py-50"
        >
            <search-result-item-component
                v-for="(result) in results"
                :key="`result-${result.id}`"
            ></search-result-item-component>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "results"]
};
</script>
