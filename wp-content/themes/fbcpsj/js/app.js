window.Vue = require('vue');

import message from './components/message.vue';
import modal from './components/modal.vue';
import tabs from './components/tabs.vue';
import tab from './components/tab.vue';
import slider from './components/slider.vue';
import slide from './components/slide.vue';
import videoModal from './components/videoModal.vue';
import GoogleMap from './components/GoogleMap.vue';

var app = new Vue({

    el: '#app',

    components: {
        message,
        modal,
        tabs,
        tab,
        slider,
        slide,
        videoModal,
        GoogleMap
    },

    data: {
        isOpen: false,
        modalOpen: false,
        vimeoCode: '',
        scrolled: false,
        windowHeight: 0
    },

    methods: {

        toggleMenu(){
            this.isOpen = !this.isOpen;
        },

        handleScroll(){
            this.scrolled = (window.scrollY > 0 ? true : false);
        }

    },

    mounted: function() {
        this.windowHeight = window.innerHeight > this.$root.$el.clientHeight ? true : false;
    },

    created: function () {
        window.addEventListener('scroll', this.handleScroll);
    },

    destroyed: function () {
        window.removeEventListener('scroll', this.handleScroll);
    }

});

