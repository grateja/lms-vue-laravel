import VueRouter from 'vue-router';

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
                component: require('./views/books/Create.vue')
            },
            {
                path: ':id',
                component: require('./views/books/Book.vue')
            }
        ]
    }
];

export default new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active'
});