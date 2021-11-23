<template>
    <ul class="flex border-b list-reset">
        <li class="mr-1 -mb-px" v-for="tab in tabs" :key="`tabs-${tab.index}`">
            <a
                :class="
                    `inline-block px-4 py-2 font-semibold bg-white text-blue-dark${
                        active === tab.index
                            ? ' rounded-t border-t border-l border-r'
                            : ''
                    }`
                "
                href="#"
                @click.prevent="$emit('setTab', tab.index)"
                >{{ tab.label }}</a
            >
        </li>
    </ul>
</template>

<script>
import { manageTabs } from "../../store/state";
export default {
    props: ["tabs", "active"],
    data: () => ({
        manageTabs
    })
};
</script>
