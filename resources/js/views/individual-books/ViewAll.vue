<template>
    <div class="view-all">
        <form method="GET" @submit.prevent="filter">
            <input type="number" v-model="keyword" class="form-control">
        </form>
        <table class="table table-hover">
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
                    <td><button type="button" @click="edit(b)" class="btn btn-default btn-xs">Edit</button></td>
                </tr>
            </tbody>
        </table>
        <pager :uri="`/individual-books/${book_id}`" :total_pages="total_pages" @navigate="load"></pager>

    </div>
</template>
<script>
import pager from '../../components/Pager.vue';

export default {
    components: {
        pager
    },
    name: 'view-all',
    data() {
        return {
            book: null,
            book_id: this.$route.params.id,
            books: null,
            keyword: this.$route.query.keyword,
            total_pages: 0
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
            });
        },
        navigate(page){
            this.load();
        },
        edit(book){
            console.log(book);
        }
    },
    created(){
        this.load();
    }
}
</script>
