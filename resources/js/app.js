window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('questions-list', require('./components/QuestionsList.vue').default);
Vue.component('exam-form', require('./components/ExamQuestion.vue').default);
Vue.component('bs-modal', require('./components/Modal.vue').default);

const app = new Vue({
    el: '#app',
})
