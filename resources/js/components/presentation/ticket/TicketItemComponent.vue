<template>
    <div class="flex flex-col w-full cursor-pointer">
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
                class="px-3 py-1 text-sm text-lg font-semibold text-white rounded-full bg-primary"
            >
                &pound;{{ ticket.cost }}
            </span>
        </div>
        <div
            class="h-32 p-4 text-sm text-white border-b border-l border-r border-light text-dark"
            v-if="live"
        >
            <p class="mb-4">{{ live ? ticket.description : "&nbsp;" }}</p>
            <button
                class="flex items-center px-4 py-2 font-semibold text-white bg-white rounded-md bg-primary justify-content"
                v-if="ticket.availability"
            >
                Book now
                <icon
                    name="chevron-right"
                    class="w-4 h-4 ml-2 text-lg text-white"
                />
            </button>
            <button
                class="flex items-center px-4 py-2 font-semibold text-white bg-white rounded-md bg-light justify-content"
                v-if="!ticket.availability"
            >
                Sold out
            </button>
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
export default {
    props: ["ticket", "live", "display"]
};
</script>
