<template>
    <layout-header active="Home"/>
    <slot></slot>
</template>

<script>
import LayoutHeader from '@/Components/Admin/LayoutHeader'
export default {
    data() {
        return {
            products: [
                { name: 'Product' },
            ]
        }
    },
    components: {
        LayoutHeader
    }
}
</script>
