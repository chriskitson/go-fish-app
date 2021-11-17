<template>
    <div
        :class="
            `p-2 my-5 border rounded-xl${type === 'error' ? ' border-error' : ''}${
                type === 'success' ? ' border-success' : ''
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
