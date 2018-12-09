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

        <blockquote v-show="loading">Please wait...</blockquote>
        <ul v-if="books.length > 0">
            <li v-for="book in books" :key="book.id">
                <div class="book">
                    <h5><router-link :to="`/books/${book.id}`" v-text="book.title"></router-link></h5>
                </div>
            </li>
        </ul>

        <blockquote v-else-if="books.length == 0 && !loading">
            No available books
        </blockquote>

        <ul class="pagination pagination-sm" v-show="page_count > 1">
            <li v-for="page in page_count" :key="page"><a href="#" @click.prevent="navigate(page)" v-text="page"></a></li>
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
            page_count: 0,
            current_page: this.$route.query.page,
            errors: [],
            loading: false
        }
    },
    methods: {
        filter(){
            this.current_page = 1;
            this.load();
        },
        load(){
            this.errors = [];
            this.loading = true;
            axios.get('/api/books', {
                params: {
                    keyword: this.query.keyword,
                    page: this.current_page
                }
            })
            .then((res, rej) => {
                this.loading = false;
                this.books = res.data.data.data;
                this.page_count = res.data.data.last_page;
                console.log(res.data.data)
            })
            .catch(err => {
                if(err.response.status == 500){
                    this.errors.push('Server is unavailable at this moment');
                } else {
                    this.errors.push(err.response.statusText);
                }
                this.loading = false;
            });
        },
        navigate(page){
            this.current_page = page;
            this.load();
        }
    },
    created(){
        this.load();
    }
}
</script>

