<template>
    <div
        :class="
            `p-2 text-sm my-5 bg-white font-bold border-2 rounded-xl${type === 'error' ? ' border-error text-error' : ''}${
                type === 'success' ? ' border-success text-success' : ''
            }`
        "
    >
        {{ message }}
    </div>
</template>

<script>
export default {
    props: ["type", "message"]
};
</script>
