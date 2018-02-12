<template>
    <div class="image-wrapper">
        <div class="image-slider-left icon is-large" @click="clickPrev" >
            <i class="fa fa-angle-left is-large" aria-hidden="true"></i>
        </div>
        <img :src="this.images[activeImage].data.attrs.src" >
        <div class="image-slider-right icon is-large" @click="clickNext" >
            <i class="fa fa-angle-right is-large" aria-hidden="true"></i>
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            imageUrl: ''
        },

        data(){
            return {
                images: [],
                activeImage: 0
            };
        },

        created(){
            this.images = this.$slots.default;
        },

        mounted(){
            this.images.forEach(image => {
                if(image.data.attrs.src === this.imageUrl){
                    this.activeImage = (image.data.attrs.index < this.images.length ? image.data.attrs.index : 0);
                }
            });
        },

        methods: {

            nextSlide(){
                this.activeImage = (this.activeImage < this.images.length -1 ? this.activeImage + 1 : 0);
            },

            prevSlide(){
                this.activeImage = (this.activeImage > 0 ? this.activeImage - 1 : this.images.length -1);
            },

            clickNext(){
                this.nextSlide()
            },

            clickPrev(){
                this.prevSlide()
            },

        }

    }
</script>