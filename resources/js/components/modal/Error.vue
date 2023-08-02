<template>
    <div class="error">
        {{ $props.message }}
    </div>
</template>
<script>
export default {
    name: 'ErrorComponent',
    props: {
        message: ''
    }
}
</script>
<style scoped>
.error{
    color: #D32F2F;
}
</style>
