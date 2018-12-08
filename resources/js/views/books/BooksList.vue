<template>
    <div class="books-list">
        <form @submit.prevent="filter" method="GET">
            <div class="row form-group">
                <input type="text" v-model="query.keyword" class="form-control input-sm">
            </div>
        </form>

        <ul>
            <li v-for="book in books" :key="book.id">
                <div class="book">
                    <h5 v-text="book.title"></h5>
                </div>
            </li>
        </ul>

    </div>
</template>

<script>
export default {
    name: 'books-list',
    data(){
        return {
            query: {
                keyword: ''
            },
            books: []
        }
    },
    methods: {
        filter(){
            axios.get('/api/books', {
                params: {
                    keyword: this.query.keyword
                }
            })
            .then((res, rej) => {
                this.books = res.data.books;
            });
        }
    }
}
</script>

