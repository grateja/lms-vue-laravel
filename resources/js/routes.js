import VueRouter from 'vue-router';

import Create from './views/books/Create.vue';

let routes = [
    {
        path: '/books',
        component: require('./views/books/BooksComponent.vue'),
        children: [
            {
                path: '/',
                component: require('./views/books/BooksList.vue')
            },
            {
                path: 'create',
                component: Create
            },
            {
                path: ':id',
                component: require('./views/books/Book.vue')
            },
            {
                path: ':id/edit',
                component: Create
            }
        ]
    },
    {
        path: '/publishers',
        component: require('./views/publishers/Index.vue'),
        children: [
            {
                path: '/',
                component: require('./views/publishers/PublisherList.vue')
            }
        ]
    }
];

export default new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active'
});