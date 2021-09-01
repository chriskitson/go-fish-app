<template>
    <div class="w-32 h-10 custom-number-input">
        <div
            class="relative flex flex-row w-full h-10 mt-1 bg-transparent rounded-lg"
        >
            <button
                data-action="decrement"
                class="w-20 h-full text-gray-600 bg-gray-300 rounded-l outline-none cursor-pointer hover:text-gray-700 hover:bg-gray-400"
                @click="$emit('down')"
            >
                <span class="m-auto text-2xl font-thin">−</span>
            </button>
            <input
                type="number"
                class="flex items-center w-full font-semibold text-center text-gray-700 bg-gray-300 outline-none focus:outline-none text-md hover:text-black focus:text-black md:text-basecursor-default"
                name="custom-input-number"
                disabled
                v-model="qty"
            />
            <button
                data-action="increment"
                class="w-20 h-full text-gray-600 bg-gray-300 rounded-r cursor-pointer hover:text-gray-700 hover:bg-gray-400"
                @click="$emit('up')"
            >
                <span class="m-auto text-2xl font-thin">+</span>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["qty"]
};
</script>
