<template>
    <div class="w-full max-w-5xl mb-10">
        <h2 class="flex items-center mb-4 text-xl font-semibold text-grey-300" v-if="title !== ''">
            {{ title }}
        </h2>
        <div v-if="results.length === 0">
            <p>There are no venues that match your search.</p>
            <p>Please try searching again.</p>
        </div>
        <div v-if="results.length > 0">
            <div class="flex flex-wrap items-center w-full space-y-4 py-50">
                <search-result-item-component
                    v-for="result in results"
                    :key="`result-${result.id}`"
                    :result="result"
                    :date="date"
                    :dateStamp="dateStamp"
                ></search-result-item-component>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "results", "date", "dateStamp"]
};
</script>
