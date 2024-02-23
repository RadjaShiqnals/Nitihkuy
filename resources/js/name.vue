<template>
    {{ computedName }}
</template>

<script>
 export default {
    props: {
        name: {
            type: String,
            default: 'RadjaShiqnals'
        }
    },
    computed: {
        computedName() {
            return this.name;
        }
    }
 }
</script>
