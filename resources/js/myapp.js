/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import store from './store'


import { ApolloClient } from 'apollo-client'
import { createHttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory'

// HTTP connection to the API
const httpLink = createHttpLink({
    // You should use an absolute URL here
    uri: 'https://manage.chatfata.com/graphql',
})

// Cache implementation
const cache = new InMemoryCache()

// Create the apollo client
const apolloClient = new ApolloClient({
    link: httpLink,
    cache,
})


require('./bootstrap');
import VueApollo from 'vue-apollo'
import VueSweetalert2 from 'vue-sweetalert2';
import vSelect from 'vue-select'




import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-select/dist/vue-select.css';


window.Vue = require('vue');

Vue.use(VueApollo)
const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
})
Vue.use(VueSweetalert2);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('v-select', vSelect)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('preparations-list', require('./components/preparations/List.vue').default);
Vue.component('add-preparation', require('./components/preparations/AddPreparation.vue').default);
Vue.component('edit-preparation', require('./components/preparations/EditPreparation.vue').default);

Vue.component('ingredients-list', require('./components/ingredients/List.vue').default);
Vue.component('add-ingredient', require('./components/ingredients/AddIngredient.vue').default);
Vue.component('edit-ingredient', require('./components/ingredients/EditIngredient.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#myvueapp',
    store: store,
    apolloProvider
});