window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('questions-list', require('./components/QuestionsList.vue').default);

const app = new Vue({
    el: '#app',
})
