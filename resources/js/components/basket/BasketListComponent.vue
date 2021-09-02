<template>
    <div class="w-full max-w-5xl mb-10">
        <div class="flex items-center mb-4">
            <h2 class="flex items-center flex-1 text-xl font-semibold">
                {{
                    live
                        ? `Basket Total: ${formatCurrency(basketTotal)}`
                        : "Basket loading..."
                }}
            </h2>
        </div>
        <div
            class="flex flex-wrap items-center w-full space-y-4 py-50"
            v-if="live && items.length > 0"
        >
            <basket-item-component
                v-for="item in items"
                :key="`live-${item.basket_id}`"
                :live="live"
                :item="item"
                :display="display"
                :auth="auth"
                :loggedIn="loggedIn"
                @remove="$emit('remove', $event)"
                @up="$emit('up', $event)"
                @down="$emit('down', $event)"
            ></basket-item-component>
        </div>
        <div v-if="live && items.length === 0">
            There are no tickets in your basket.
        </div>
        <div
            class="flex flex-wrap items-center w-full space-y-4 py-50"
            v-if="!live"
        >
            <basket-item-component
                :live="live"
                :display="display"
            ></basket-item-component>
            <basket-item-component
                :live="live"
                :display="display"
            ></basket-item-component>
            <basket-item-component
                :live="live"
                :display="display"
            ></basket-item-component>
            <basket-item-component
                :live="live"
                :display="display"
            ></basket-item-component>
        </div>
        <div class="flex items-center mt-5" v-if="basketTotal > 0">
            <span class="flex-1"></span>
            <span class="text-lg"
                >Booking Fee: {{ formatCurrency(bookingFee) }}</span
            >
        </div>
        <div class="flex items-center mt-10" v-if="basketTotal > 0">
            <span class="flex-1"> </span>
            <button
                @click="$emit('checkout')"
                class="flex items-center px-4 py-2 text-lg font-semibold text-white bg-white rounded-md cursor-pointer bg-primary justify-content"
            >
                Checkout Total: {{ formatCurrency(basketTotal + bookingFee) }}
                <icon name="chevron-right" class="w-5 h-5 ml-2 text-white" />
            </button>
        </div>
        <div class="flex items-center mt-10" v-if="basketTotal === 0">
            <span class="flex-1"> </span>
            <a
                href="/"
                class="flex items-center px-4 py-2 text-lg font-semibold text-white bg-white rounded-md cursor-pointer bg-primary justify-content"
                >Find Tickets
                <icon name="chevron-right" class="w-5 h-5 ml-2 text-white"
            /></a>
        </div>
    </div>
</template>

<script>
import { formatCurrency } from "../../utils";
export default {
    props: [
        "basketTotal",
        "items",
        "live",
        "display",
        "auth",
        "loggedIn",
        "bookingFee"
    ],
    data: () => ({
        formatCurrency
    })
};
</script>
