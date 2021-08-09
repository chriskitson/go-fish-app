<template>
    <div class="flex items-center w-full mt-5">
        <div
            class="flex items-center w-auto h-12 max-w-5xl text-sm border rounded-lg border-light bg-primary"
        >
            <BeakerIcon class="w-5 h-5 text-blue-500" v-id/>
            <input type="text" class="w-40 h-12 px-2 border-t border-b rounded-tl-lg rounded-bl-lg border-light" value="Monday 9th August" />
            <input type="text" class="h-12 px-2 border-t border-b border-l w-96 border-light" value="Enter Name, City or Post Code" />
            <button class="h-12 px-8 text-white border rounded-lg bg-primary border-primary">Search</button>
        </div>
    </div>
</template>

<script>
import { BeakerIcon } from '@heroicons/vue/outline'
export default {
    components: { BeakerIcon }
};
</script>
