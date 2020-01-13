/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from "vue-router";
import VueSpinners from 'vue-spinners'
import swal from 'sweetalert2'
import moment from 'moment';
import print from 'print-js'
import excel from 'vue-excel-export'

Vue.use(excel);
Vue.use(VueRouter);
Vue.use(VueSpinners);
Vue.filter('MyDate', function (date) {
    return moment(date).format('MMMM Do YYYY');
});

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    // timerProgressBar: true,

});
window.toast = toast;
window.Fire = new Vue();
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('header-component', require('./components/Header.vue').default);
Vue.component('transfer-component', require('./components/TrnsferMoney/TransferMoney.vue').default);
Vue.component('register-component', require('./components/Register.vue').default);
Vue.component('transaction-component', require('./components/Transaction.vue').default);
Vue.component('details-component', require('./components/DetailsTransaction.vue').default);
let routes = [
    {path: '/header', component: require('./components/Header.vue').default},
    {path: '/example', component: require('./components/ExampleComponent.vue').default},
    {path: '/transaction', component: require('./components/TrnsferMoney/TransferMoney.vue').default},
    {path: '/register', component: require('./components/Register.vue').default},
    {path: '/details/:code', component: require('./components/DetailsTransaction.vue').default, name: 'details'},
    {path: '/report', component: require('./components/Transaction.vue').default},
    {path: '/member', component: require('./components/Member.vue').default},
    {path: '/search', component: require('./components/SearchTransaction.vue').default},
    {path: '/receiver/:code', component: require('./components/ReceiverTransaction.vue').default, name: 'receiver'},
    {path: '/profile/:code', component: require('./components/Profile.vue').default, name: 'profile'},
    {path: '/setting', component: require('./components/Settings/GeneralSetting.vue').default},
    {path: '/wallet', component: require('./components/Wallet.vue').default},
    {path: '/home', component: require('./components/Statistics.vue').default},
    {path: '/fish/:code', component: require('./components/FishTransaction.vue').default},
];
const router = new VueRouter({
    mode: "history",
    routes
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data() {
        return {
            search: ''
        }
    },
    methods: {
        printme() {
            window.print();
        }
    }

});
