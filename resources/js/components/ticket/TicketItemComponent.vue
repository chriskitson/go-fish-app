<template>
    <div class="flex flex-col w-full">
        <div
            class="flex items-center w-full h-12 px-2 border justify-items bg-grey-300 border-grey-300"
            v-if="live"
        >
            <icon
                name="ticket"
                class="mr-2 text-lg text-white w-7 h-7"
                v-if="live"
            />
            <span class="flex-grow font-semibold text-white">
                {{ live ? ticket.name : "&nbsp;" }}
            </span>
            <span
                class="px-3 py-1 text-lg font-semibold text-white bg-orange-200 rounded-full"
            >
                {{ formatCurrency(ticket.cost) }}
            </span>
        </div>
        <div
            class="p-4 text-sm text-white border-b border-l border-r border-grey-200 text-grey-300"
            v-if="live && auth && !loggedIn"
        >
            <p>
                You must <a href="/login" class="text-red-200">log in</a> in
                order to book.
            </p>
        </div>
        <div
            class="p-4 text-sm text-white border-b border-l border-r border-grey-300 text-grey-300"
            v-if="live && (!auth || loggedIn)"
        >
            <p class="mb-4">{{ ticket.description }}</p>

            <div
                class="flex flex-col flex-wrap items-center w-full md:flex-row"
            >
                <quantity-selector-component
                    class="md:mr-2"
                    v-if="ticket.availability"
                    :qty="qty"
                    @up="up"
                    @down="down"
                ></quantity-selector-component>
                <button
                    @click="
                        $emit('book', {
                            ticket_id: ticket.id,
                            venue_id: ticket.venue_id,
                            qty
                        })
                    "
                    class="flex items-center w-full px-4 py-2 mb-4 font-semibold text-center text-white bg-white bg-red-200 rounded-md cursor-pointer md:mb-0 justify-content md:w-auto"
                    v-if="ticket.availability"
                >
                    <span class="flex-1">{{
                        ticket.user === 0 ? "Add to cart" : "Add to cart again"
                    }}</span>
                    <icon
                        name="chevron-right"
                        class="w-4 h-4 ml-2 text-lg text-white"
                    />
                </button>
                <span
                    class="flex items-center w-full px-4 py-2 font-semibold text-center text-white bg-white rounded-md bg-grey-300 justify-content md:w-auto"
                    v-if="!ticket.availability"
                >
                    <span class="flex-1">Sold out</span>
                    <icon
                        name="x-circle"
                        class="w-4 h-4 ml-2 text-lg text-white"
                    />
                </span>
                <span
                    class="flex-1"
                    v-if="
                        ticket.status !== '' ||
                            ticket.error !== '' ||
                            ticket.success !== ''
                    "
                ></span>
                <status-component
                    v-if="ticket.error !== ''"
                    :status="ticket.error"
                    class="w-full md:w-auto"
                    type="error"
                ></status-component>
                <status-component
                    v-if="ticket.success !== ''"
                    :status="ticket.success"
                    class="w-full md:w-auto"
                    type="success"
                ></status-component>
                <status-component
                    v-if="
                        ticket.error === '' &&
                            ticket.status !== '' &&
                            ticket.success === ''
                    "
                    class="w-full md:w-auto"
                    :status="ticket.status"
                ></status-component>
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
import { formatCurrency } from "../../utils";
export default {
    props: ["ticket", "live", "display", "auth", "loggedIn"],
    data: () => ({
        qty: 1,
        formatCurrency
    }),
    methods: {
        up() {
            this.qty++;
        },
        down() {
            this.qty--;
        }
    }
};
</script>
