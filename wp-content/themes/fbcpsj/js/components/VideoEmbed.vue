<template>
    <div class="embed-responsive" :class="{ 'vertical': this.aspectRatio === 'vertical' }">
        <slot></slot>
    </div>
</template>
<script>
    export default {
        props: {
            aspectRatio: ''
        }
    }
</script>