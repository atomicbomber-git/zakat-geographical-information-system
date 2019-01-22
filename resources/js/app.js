
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


// numeral.js

import numeral from 'numeral'

numeral.register('locale', 'id', {
    delimiters: {
        thousands: '.',
        decimal: ','
    },
    abbreviations: {
        thousand: 'Ribu',
        million: 'Juta',
        billion: 'Miliar',
        trillion: 'Triliun'
    },
    currency: {
        symbol: 'Rp.'
    }
});

numeral.locale('id')

window.numeral = numeral

const app = new Vue({
    el: '#app'
});
