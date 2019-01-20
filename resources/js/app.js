
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import * as VueGoogleMaps from 'vue2-google-maps'

// Add Vue-2 Frappe Charts
import Chart from 'vue2-frappe'
Vue.use(Chart)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyBDzI0csQYqh24xwIyl_-rlKynmiam4DGU',
      libraries: 'places',
    },
})

Vue.component('receiver', require('./components/Receiver.vue'));
Vue.component('guest-map', require('./components/GuestMap.vue'));
Vue.component('guest-chart', require('./components/GuestChart.vue'));

Vue.component('collector-create', require('./components/collector/Create.vue'));
Vue.component('collector-edit', require('./components/collector/Edit.vue'));
Vue.component('collector-donation-create', require('./components/collector/donation/Create.vue'));
Vue.component('collector-donation-edit', require('./components/collector/donation/Edit.vue'));


const app = new Vue({
    el: '#app'
});
