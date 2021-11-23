<template>
    <div class="mb-8">
        <h3 class="my-8 text-xl font-semibold text-red-200">
            Opening Hours
        </h3>
        <div class="mb-8">
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
    </div>
</template>

<script>
export default {
    props: ["venue"]
};
</script>
