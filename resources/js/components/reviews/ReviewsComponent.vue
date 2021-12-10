<template>
    <div class="pt-8 mb-8 border-t border-grey-100">
        <h3 class="mb-4 text-lg font-semibold">Reviews of {{ name }}:</h3>
        <div class="grid grid-cols-1 gap-2">
            <div
                class="p-4 mb-2 rounded-md bg-grey-100"
                v-for="(review, i) in reviews"
                :key="`venue-review-${i}`"
            >
                <rating-component
                    :max="5"
                    :current="parseFloat(review.rating) || 0"
                ></rating-component>
                <div v-html="review.text"></div>
                <div class="mt-2 text-sm font-semibold">
                    {{ review.name }} -
                    {{ formatDateDisplayFromTime(review.time) }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { formatDateDisplayFromTime } from "../../utils";
export default {
    props: ["name", "reviews"],
    data: () => ({
        formatDateDisplayFromTime
    })
};
</script>
