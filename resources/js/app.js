/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('make-format', require('./components/MakeFormat.vue').default);
Vue.component('test', require('./components/test.vue').default);
Vue.component('edit-format', require('./components/format/editFormat.vue').default);
Vue.component('insert-button', require('./components/format/insertButton.vue').default);
Vue.component('send-format', require('./components/format/sendFormat.vue').default);
Vue.component('make-tweet', require('./components/make/MakeTweet.vue').default);
Vue.component('make-business-tweet', require('./components/business/make/MakeTweet.vue').default);
Vue.component('header-vue', require('./components/header/Header.vue').default);
Vue.component('edit-business-format', require('./components/business/format/editFormat.vue').default);
Vue.component('send-business-format', require('./components/business/format/sendFormat.vue').default);
// Vue.component('insert-numbers', require('./components/make/InsertNumbers.vue').default);
// Vue.component('input-numbers', require('./components/make/InputNumbers.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

const app2 = new Vue({
    el:'#app2',
})
