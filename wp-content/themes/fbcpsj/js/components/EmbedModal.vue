<template>
    <div class="video-wrapper" :class="{ 'vertical': this.aspectRatio === 'vertical' }">
        <iframe :src="this.htmlContent" height="768" width="1024" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ></iframe>
    </div>
</template>

<script>
    export default {
        props: {
            htmlContent: '',
            aspectRatio: ''
        }
    }
</script>