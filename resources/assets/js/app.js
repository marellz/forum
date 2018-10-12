require('./bootstrap')
require('ionicons/dist/css/ionicons.min.css')
window.Vue = require('vue');
Vue.component('thread-view', require('./components/ThreadView.vue'));
Vue.component('search-component', require('./components/Search.vue'));
Vue.component('notification-component', require('./components/Notifications.vue'));
const app = new Vue({
    el: '#app'
});
