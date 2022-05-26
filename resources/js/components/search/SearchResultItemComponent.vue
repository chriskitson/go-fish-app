<template>
    <div class="relative flex w-full p-4 rounded-md text-grey-300 bg-grey-100">
        <a :href="`/venue/${result.id}/${dateStamp}`">
            <span
                :style="
                    `background-image:url('${
                        result.image ? result.image : ''
                    }')`
                "
                class="flex items-center w-48 h-32 mr-4 bg-cover bg-bottom bg-grey-200 justify-content"
                ></span
            >
        </a>
        <div class="flex flex-col">
            <rating-component
                :max="5"
                :current="parseFloat(result.rating) || 0"
            ></rating-component>
            <a :href="`/venue/${result.id}/${dateStamp}`" class="text-lg font-bold"
                >{{ result.name }} - {{ result.distanceDisplay }}</a
            >
            <span class="text-sm">{{ result.address }}</span>
            <span
                class="flex items-center mt-2 text-sm justify-content text-grey-300"
                v-if="result.tickets.length > 0"
                ><icon name="ticket" class="w-4 h-4 mr-2" /> There
                {{
                    result.tickets.length === 1
                        ? `is ${result.tickets.length} type`
                        : `are ${result.tickets.length} types`
                }}
                of tickets available on {{ date }} from {{result.tickets.length > 0 ? formatCurrency(result.tickets.map(t => t.cost).sort((a,b) => a - b)[0]) : formatCurrency('0')}}.</span
            >
            <span
                class="flex items-center mt-2 text-sm justify-content text-grey-300"
                v-if="result.tickets.length === 0"
                ><icon name="ticket" class="w-4 h-4 mr-2" /> There are no
                tickets available on {{ date }}.</span
            >
        </div>
    </div>
</template>

<script>
import { formatCurrency } from "../../utils";
export default {
    props: ["result", "date", "dateStamp"],
    data: () => ({
        formatCurrency
    })
};
</script>