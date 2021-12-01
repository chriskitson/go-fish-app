<template>
    <div class="w-full max-w-5xl mb-10">
        <h2 class="flex items-center mb-4 text-xl font-semibold text-grey-300">
            Reviews
        </h2>
        <div v-if="reviews.length === 0">
            <p>There are no reviews for {{name}}.</p>
        </div>
        <div v-if="reviews.length > 0">
            <div class="flex flex-wrap items-center w-full space-y-4 py-50">
                <review-item-component
                    v-for="(review, index) in reviews"
                    :key="`review-${index}`"
                    :review="review"
                ></review-item-component>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["name", "reviews"]
};
</script>
