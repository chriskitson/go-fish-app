<template>
    <div class="w-32 h-9 custom-number-input">
        <div
            class="relative flex flex-row w-full bg-transparent rounded-lg h-9"
        >
            <button
                data-action="decrement"
                class="w-20 h-full text-gray-600 rounded-l outline-none cursor-pointer bg-secondary hover:text-gray-700 hover:bg-primary"
                @click="$emit('down')"
            >
                <span class="m-auto text-2xl font-thin">−</span>
            </button>
            <input
                type="number"
                class="flex items-center w-full font-semibold text-center text-gray-700 outline-none bg-secondary focus:outline-none text-md hover:text-black focus:text-black md:text-basecursor-default"
                name="custom-input-number"
                disabled
                v-model="qty"
            />
            <button
                data-action="increment"
                class="w-20 h-full text-gray-600 rounded-r cursor-pointer bg-secondary hover:text-gray-700 hover:bg-primary"
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
