<template>
    <div class="flex flex-col w-full">
        <div
            :class="`flex flex-col items-center w-full px-2 py-2 border md:py-0 md:h-12 justify-items ${item.valid ? 'bg-grey-300 border-grey-300' : 'bg-red-200 border-red-200'} md:flex-row`"
            v-if="live"
        >
            <icon
                name="ticket"
                class="mr-2 text-lg text-white w-7 h-7"
                v-if="live"
            />
            <span class="flex-grow font-semibold text-white">
                {{
                    live ? `${item.venue_name} - ${item.ticket_name}` : "&nbsp;"
                }}
                {{
                    !item.valid ? ' (Invalid)' : ''
                }}
            </span>
            <span
                class="px-3 py-1 mt-2 text-lg font-semibold text-white bg-orange-200 rounded-full md:mt-0"
            >
                {{ formatCurrency(item.basket_qty * item.ticket_cost) }}
            </span>
        </div>
        <div
            class="p-4 text-sm text-white border-b border-l border-r border-grey-300 text-grey-300"
            v-if="live && (!auth || loggedIn)"
        >
            <p class="mb-4">
                <strong>Date of entry:</strong>
                {{ formatDateDisplay(parseISO(item.date)) }}
            </p>
            <p class="mb-4">{{ item.ticket_description }}</p>
            <p v-if="item.error !== ''" class="mb-4">
                <status-component
                    :status="item.error"
                    type="error"
                ></status-component>
            </p>
            <div class="flex flex-col items-center w-full md:flex-row">
                <quantity-selector-component
                    class="mr-2"
                    :qty="item.basket_qty"
                    @up="$emit('up', { id: item.basket_id })"
                    @down="$emit('down', { id: item.basket_id })"
                ></quantity-selector-component>
                <span class="ml-2"
                    >X {{ formatCurrency(item.ticket_cost) }} each</span
                >
                <span class="flex-1"></span>
                <button
                    class="mt-2 text-red-200 md:mt-0"
                    @click="$emit('remove', { id: item.basket_id })"
                >
                    <icon name="trash" class="ml-2 w-7 h-7" />
                </button>
            </div>
        </div>
        <div
            class="border h-44 bg-grey-200 border-grey-200 bg-opacity-10"
            v-if="!live"
        >
            &nbsp;
        </div>
    </div>
</template>

<script>
import { formatCurrency, formatDateDisplay } from "../../utils";
import { parseISO } from "date-fns";
export default {
    props: ["item", "live", "display", "auth", "loggedIn"],
    data: () => ({
        formatCurrency,
        formatDateDisplay,
        parseISO
    })
};
</script>
