<template>
    <div class="books-list">
        <form @submit.prevent="filter" method="GET">
            <div class="row form-group">
                <input type="text" v-model="query.keyword" class="form-control input-sm">
            </div>

            <router-link to="/books/create">Create new</router-link>
        </form>

        <div class="text-danger" v-if="(errors.length > 0)">
            <ul>
                <li v-for="(error, i) in errors" :key="i" v-text="error"></li>
            </ul>
        </div>

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
            books: [],
            errors: []
        }
    },
    methods: {
        filter(){
            this.errors = [];
            axios.get('/api/books', {
                params: {
                    keyword: this.query.keyword
                }
            })
            .then((res, rej) => {
                this.books = res.data.books;
            })
            .catch(err => {
                if(err.response.status == 500){
                    this.errors.push('Server is unavailable at this moment');
                } else {
                    this.errors.push(err.response.statusText);
                }
                console.log(err.response)
            });
        }
    },
    created(){
        this.filter();
    }
}
</script>

