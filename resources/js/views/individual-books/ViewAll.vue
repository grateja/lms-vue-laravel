<template>
    <div class="view-all">
        <form method="GET" @submit.prevent="filter">
            <input type="number" v-model="keyword" class="form-control">
        </form>
        <table class="table table-hover" v-if="books && books.length > 0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>UNIQUE ID</th>
                    <th>AVAILABILITY</th>
                    <th>CONDITION</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="b in books" :key="b.id">
                    <td>{{b.id}}</td>
                    <td>{{b.unique_id}}</td>
                    <td>{{b.availability}}</td>
                    <td>{{b.condition?b.condition.name:'N/A'}}</td>
                    <td>
                        <button type="button" @click="edit(b)" class="btn btn-default btn-xs">Edit</button>
                        <button type="button" @click="delete_book($event, b)" class="btn btn-default btn-xs">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <blockquote v-else-if="loading">
            Please wait...
        </blockquote>
        <blockquote v-else>
            No books
        </blockquote>
        <pager :uri="`/individual-books/${book_id}`" :total_pages="total_pages" @navigate="navigate" @beforeNavigate="beforeNavigate"></pager>

        <edit :book="individualBook" v-if="individualBook != null" @close="individualBook = null" :book_conditions="book_conditions" @save="save"></edit>
    </div>
</template>
<script>
import pager from '../../components/Pager.vue';
import edit from './Edit.vue';

export default {
    components: {
        pager,
        edit
    },
    name: 'view-all',
    data() {
        return {
            book: null,
            book_id: this.$route.params.id,
            individualBook: null,
            books: null,
            keyword: this.$route.query.keyword,
            total_pages: 0,
            book_conditions:null,
            loading: false
        }
    },
    methods: {
        filter() {
            this.$router.push({
                path: `/individual-books/${this.book_id}`,
                query: { keyword: this.keyword, page: this.$route.query.page }
            });
            this.load();
        },
        load() {
            this.loading = true;
            axios.get(`/api/individual-books/${this.book_id}`,{
                params: {
                    keyword: this.keyword,
                    page: this.$route.query.page
                }
            }).then((res, rej) => {
                console.log(res);
                this.book = res.data.data.book;
                this.books = res.data.data.books.data;
                this.total_pages = res.data.data.books.last_page;
                this.loading = false;
            });
        },
        navigate(page){
            this.load();
        },
        beforeNavigate(){
            this.books = [];
        },
        edit(book) {
            this.individualBook = book;
        },
        save(book) {
            console.log('saved', book);
            this.books = this.books.map(b => {
                if(b.id == book.id) {
                    console.log("matched", book);
                    return book;
                }
                return b;
            });
            this.individualBook = null;
        },
        delete_book(e, book){
            if(confirm("Are you sure you want to delete this item?")){
                e.target.innerHTML = "Please wait...";
                e.target.disabled = true;
                axios.delete(`/api/individual-books/${book.id}`).then((res) => {
                    this.load();
                }).catch(err => {
                    e.target.innerHTML = "Retry delete";
                    e.target.disabled = false;
                });
            }
        }
    },
    created(){
        this.load();

        axios.get('/api/book-conditions').then((res) => {
            this.book_conditions = res.data;
        });
    }
}
</script>
