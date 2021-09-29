<template>
    <span
        :class="
            `px-3 py-1 border rounded-full${
                type === 'error' ? ' border-error text-error' : ''
            }${type === 'success' ? ' border-success text-success' : ''}${
                !type || type === '' ? ' border-grey-300 text-grey-300' : ''
            }`
        "
    >
        {{ status }}
    </span>
</template>

<script>
export default {
    props: ["type", "status"]
};
</script>
