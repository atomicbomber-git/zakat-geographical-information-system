
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import sweetalert from 'sweetalert'
window.swal = sweetalert

// Add Vue Multiselect CSS
import 'vue-multiselect/dist/vue-multiselect.min.css'

// Add Vue-2 Frappe Charts
import Chart from 'vue2-frappe'
Vue.use(Chart)

// Add vue-js-modal
import VModal from 'vue-js-modal'
Vue.use(VModal)

// Add Vue Google Maps
import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyBDzI0csQYqh24xwIyl_-rlKynmiam4DGU',
      libraries: 'places',
      language: 'id',
    },
})

// Register all Vue components
Vue.component('receivement-base-chart', require('./components/shared/ReceivementChart.vue'));
Vue.component('donation-base-chart', require('./components/shared/DonationChart.vue'));
Vue.component('receiver', require('./components/Receiver.vue'));
Vue.component('guest-map', require('./components/GuestMap.vue'));
Vue.component('guest-chart', require('./components/GuestChart.vue'));
Vue.component('receivement-chart', require('./components/receivement/Chart.vue'));
Vue.component('receivement-detail-chart', require('./components/receivement/DetailChart.vue'));
Vue.component('donation-chart', require('./components/donation/Chart.vue'));
Vue.component('donation-detail-chart', require('./components/donation/DetailChart.vue'));
Vue.component('collector-create', require('./components/collector/Create.vue'));
Vue.component('collector-edit', require('./components/collector/Edit.vue'));
Vue.component('collector-donation-create', require('./components/collector/donation/Create.vue'));
Vue.component('collector-donation-edit', require('./components/collector/donation/Edit.vue'));
Vue.component('collector-receivement-create', require('./components/collector/receivement/Create.vue'));
Vue.component('collector-receivement-edit', require('./components/collector/receivement/Edit.vue'));
Vue.component('collector-mustahiq-create', require('./components/collector/mustahiq/Create.vue'));
Vue.component('collector-mustahiq-edit', require('./components/collector/mustahiq/Edit.vue'));
Vue.component('collector-muzakki-create', require('./components/collector/muzakki/Create.vue'));
Vue.component('collector-muzakki-edit', require('./components/collector/muzakki/Edit.vue'));

const app = new Vue({
    el: '#app'
});

import numeral from './numeral.js'
window.numeral = numeral

import { getDistance } from './helpers.js'
window.example = getDistance