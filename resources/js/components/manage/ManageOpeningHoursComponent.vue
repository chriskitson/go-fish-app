<template>
    <div class="mb-8">
        <div class="mb-8 md:grid md:grid-cols-2 md:gap-6">
            <div>
                <h3 class="my-8 text-xl font-semibold text-red-200">
                    Opening Days
                </h3>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.sunday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Sunday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.monday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Monday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.tuesday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Tuesday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.wednesday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Wednesday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.thursday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Thursday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.friday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Friday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.saturday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Saturday</span>
                    </label>
                </div>
            </div>
            <div>
                <h3 class="my-8 text-xl font-semibold text-red-200">
                    Closed Dates
                </h3>
                <div v-if="venue.closed.length === 0" class="p-2 my-4 bg-light">
                    There are no closure dates for this venue.
                </div>
                <div
                    v-for="(range, index) in venue.closed"
                    :key="`closed-${range.id}`"
                    :class="`flex p-2${index % 2 ? ' bg-white' : ' bg-grey-100'}`"
                >
                    <span class="flex-1">
                        {{ formatDateDisplay(range.start_date) }} -
                        {{ formatDateDisplay(range.end_date) }}
                    </span>
                    <button
                        @click="$emit('delete', range.id)"
                        class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                        :disabled="loading"
                    >
                        <icon name="trash" class="w-4 h-4" />
                    </button>
                </div>
                <div class="mt-8 md:grid md:grid-cols-3 md:gap-6">
                    <div class="mb-8 md:mb-0">
                        <label class="block mb-2 font-semibold text-grey-300"
                            >Start date</label
                        >
                        <client-only>
                            <date-picker
                                :value="closed.start"
                                type="date"
                                :clearable="false"
                                :disabled-date="disableDate"
                                v-on:change="$emit('start', $event)"
                                class="w-full border rounded-md top-date-picker border-ligh"
                                format="DD/MM/YYYY"
                            ></date-picker>
                        </client-only>
                    </div>
                    <div class="mb-8 md:mb-0">
                        <label class="block mb-2 font-semibold text-grey-300"
                            >End date</label
                        >
                        <client-only>
                            <date-picker
                                :value="closed.end"
                                type="date"
                                :clearable="false"
                                :disabled-date="disableDate"
                                v-on:change="$emit('end', $event)"
                                class="w-full border rounded-md top-date-picker border-light"
                                format="DD/MM/YYYY"
                            ></date-picker>
                        </client-only>
                    </div>
                    <div class="flex flex-col-reverse">
                        <button
                            class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                            :disabled="loading"
                            @click="$emit('add')"
                        >
                            Add Date Range
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ClientOnly from "vue-client-only";
import DatePicker from "vue2-datepicker";
import { formatDateDisplay } from "../../utils";
export default {
    props: ["venue", "closed", "loading"],
    components: {
        ClientOnly,
        DatePicker
    },
    methods: {
        disableDate(date) {
            return date < new Date();
        }
    },
    data: () => ({
        formatDateDisplay
    })
};
</script>
