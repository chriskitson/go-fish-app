<template>
    <span
        :class="
            `px-3 py-1 border rounded-full${
                type === 'error' ? ' border-error text-error' : ''
            }${type === 'success' ? ' border-success text-success' : ''}${
                !type || type === '' ? ' border-primary text-primary' : ''
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
