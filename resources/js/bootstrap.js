import Vue from 'vue';
import axios from 'axios';

Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-autorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-token', require('./components/passport/PersonalAccessTokens.vue'));

window.Vue = Vue;

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.headers.common['Authorization'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE0ZTMzMmQ4YTFjYzVhYWMzZjI0YjBjNWZjMzY4NjUyNjkwNzUyNjU4YmZmZDRhMGY5ZDdlOWEyYzdkOGMwODdlZGYyNWM2ZDdhODE3ODRkIn0.eyJhdWQiOiIzIiwianRpIjoiMTRlMzMyZDhhMWNjNWFhYzNmMjRiMGM1ZmMzNjg2NTI2OTA3NTI2NThiZmZkNGEwZjlkN2U5YTJjN2Q4YzA4N2VkZjI1YzZkN2E4MTc4NGQiLCJpYXQiOjE1NDU1NDE5NDMsIm5iZiI6MTU0NTU0MTk0MywiZXhwIjoxNTc3MDc3OTQzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.OTeInuQ7qs5QthW5eZnOj-Lj3y5tVCR6yewMVALEeoh7nV1Vey8eNdRe_4dYOO3bXXsfn--FxSwS699UYljprxfGaa9H54815h1pbRzFuEoYv5u8GOt2N3ZBdXBnFz4GWdr79642OAQW5tSMNjJMaagCxjHxRr3UZ8lkujnV3kDkjB5wJitVh3AbX2N794kBU8PiXpFykm-0MaRb1xUflt7UzQ82iewlJkRKLxDJHjMgRCN6XpXNGuMYhY5KcjpnAKkPQp1lDOpRe1DGY7YdIogkMIuZIDiiWprd73borCmLIMJOpaFW_KAXiKOqu98WHCVo0yZFRRxVkdxhE-RsMWAYPvzOB0qI6AE-lFFGMdvfTo5948fXF0zOjjUpQyoT1oY7jACOSSipstdByoKQb4s2-Fz4-ej29IDgqVu5E9C1Bb6rvp6BCU4W88qBl1yPcXwm_Z5mlqvQlWTXzewltDDi7N5Yv9ZA86qbahvcL92xAerAaJ1A3XTkfCMYObPunpmS-e8lhgfToIJpRewczo69gfC-jSf7mcsb48K2uOFEIfkDtRpR01fgmAQwiOwVrrnl7F5CT1pd-GDNyj9rxfXihwN9BI6i0UlfwN7IAUwXWngUmeKtl8_p-TOkMP3eDcHkdZ2XChkU5Q067wcwdaLQa5EUh1BnDYm6RwqXvQY';

window.$ = require('jquery');

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

//let token = document.head.querySelector('meta[name="csrf-token"]');
let token = localStorage.getItem('token');

if (token) {
    //window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
} else {
    console.log('not logged in')
    // console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
