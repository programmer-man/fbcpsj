<template>
    <div class="video-wrapper">
        <iframe :src="'https://player.vimeo.com/video/' + this.vimeoCode + '?autoplay=1&title=0&byline=0&portrait=0'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    </div>
</template>

<script>
    export default {
        props: {
            vimeoCode: false
        }
    }
</script>