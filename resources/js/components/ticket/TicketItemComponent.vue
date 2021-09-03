<template>
    <div class="flex flex-col w-full">
        <div
            class="flex items-center w-full h-12 px-2 border justify-items bg-secondary border-light"
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
                class="px-3 py-1 text-lg font-semibold text-white rounded-full bg-primary"
            >
                {{ formatCurrency(ticket.cost) }}
            </span>
        </div>
        <div
            class="p-4 text-sm text-white border-b border-l border-r border-light text-dark"
            v-if="live && auth && !loggedIn"
        >
            <p>
                You must <a href="/login" class="text-primary">log in</a> in
                order to book.
            </p>
        </div>
        <div
            class="p-4 text-sm text-white border-b border-l border-r border-light text-dark"
            v-if="live && (!auth || loggedIn)"
        >
            <p class="mb-4">{{ ticket.description }}</p>

            <div class="flex items-center w-full">
                <quantity-selector-component
                    class="mr-2"
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
                    class="flex items-center px-4 py-2 font-semibold text-white bg-white rounded-md cursor-pointer bg-primary justify-content"
                    v-if="ticket.availability"
                >
                    {{ ticket.user === 0 ? "Add to cart" : "Add to cart again" }}
                    <icon
                        name="chevron-right"
                        class="w-4 h-4 ml-2 text-lg text-white"
                    />
                </button>
                <span
                    class="flex items-center px-4 py-2 font-semibold text-white bg-white rounded-md bg-light justify-content"
                    v-if="!ticket.availability"
                >
                    Sold out
                    <icon
                        name="x-circle"
                        class="w-4 h-4 ml-2 text-lg text-white"
                    />
                </span>
                <span
                    class="flex-1"
                    v-if="ticket.status !== '' || ticket.error !== '' || ticket.success !== ''"
                ></span>
                <status-component
                    v-if="ticket.error !== ''"
                    :status="ticket.error"
                    type="error"
                ></status-component>
                <status-component
                    v-if="ticket.success !== ''"
                    :status="ticket.success"
                    type="success"
                ></status-component>
                <status-component
                    v-if="
                        ticket.error === '' &&
                            ticket.status !== '' &&
                            ticket.success === ''
                    "
                    :status="ticket.status"
                ></status-component>
            </div>
        </div>
        <div
            class="border h-44 bg-secondary border-light bg-opacity-10"
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
