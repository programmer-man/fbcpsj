window.Vue = require('vue');

import message from './components/message.vue';
import modal from './components/modal.vue';
import tabs from './components/tabs.vue';
import tab from './components/tab.vue';
import slider from './components/slider.vue';
import slide from './components/slide.vue';
import GoogleMap from './components/GoogleMap.vue';

var app = new Vue({

    el: '#app',

    components: {
        'message' : message,
        'modal' : modal,
        'tabs' : tabs,
        'tab' : tab,
        'slider' : slider,
        'slide' : slide,
        'google-map' : GoogleMap
    },

    data(){
        return {
            isOpen: false,
            scrolled: false,
            windowHeight: 0
        }
    },

    methods: {

        toggleMenu(){
            this.isOpen = !this.isOpen;
        },

        handleScroll(){
            this.scrolled = window.scrollY > 0;
        }

    },

    mounted: function() {
        this.windowHeight = window.innerHeight > this.$root.$el.clientHeight;
    },

    created: function () {
        window.addEventListener('scroll', this.handleScroll);
    },

    destroyed: function () {
        window.removeEventListener('scroll', this.handleScroll);
    }

});

