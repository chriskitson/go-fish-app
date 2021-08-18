<template>
    <div class="w-full max-w-5xl mx-auto">
        <top-search-component
            :venueSearch="venueSearch"
            :date="dateSearch"
            @set="$emit('setLocation', $event)"
            @search="$emit('searchVenues', $event)"
        ></top-search-component>
        <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
            <div>
                <img
                    src="/images/river.jpg"
                    class="w-full mb-5 rounded-md"
                    alt=""
                />
                <h1 class="text-xl font-semibold">{{ venueDetail.name }}</h1>
                <p class="mb-10 text-sm font-semibold">
                    {{ venueDetail.address }}
                </p>
                <p class="text-sm">{{ venueDetail.description }}</p>
                <div class="flex mt-5">
                    <button
                        class="flex items-center justify-center px-3 py-1 mr-2 text-sm border rounded-lg border-light bg-secondary"
                    >
                        <icon name="location-marker" class="w-4 h-4 mr-2" />
                        Directions
                    </button>
                             <button
                        class="flex items-center justify-center px-3 py-1 text-sm border rounded-lg border-light bg-secondary"
                    >
                        <icon name="pencil" class="w-4 h-4 mr-2" />
                        Review
                    </button>
                </div>
                <div class="p-5 mt-10 border border-light text-dark">
                    <h2 class="mb-2 font-semibold">Rules</h2>
                    <ul>
                        <li class="text-sm">Example rule</li>
                        <li class="text-sm">Example rule</li>
                        <li class="text-sm">Example rule</li>
                    </ul>
                </div>
            </div>
            <div class="col-span-2">main</div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["venueSearch", "dateSearch", "venueDetail"]
};
</script>
