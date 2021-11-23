<template>
    <div class="mb-8">
        <h3 class="my-8 text-xl font-semibold text-red-200">
            Payment
        </h3>
        <div class="md:grid md:grid-cols-2 md:gap-6">
            <div class="mb-8 md:mb-0">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Stripe Account</label
                >
                <input
                    type="text"
                    :class="
                        `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
                            'account'
                        )}`
                    "
                    :disabled="loading"
                    v-model="venue.account"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["loading", "venue", "manageVenueErrorFields"],
    methods: {
        errorStyle(key) {
            return this.manageVenueErrorFields?.indexOf(key) > -1
                ? " border-red-200"
                : "";
        }
    }
};
</script>
