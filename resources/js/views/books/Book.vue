<template>
    <div class="book">
        <h3>This is a fucking book</h3>
        <router-link :to="`/individual-books/${book.id}`">View all</router-link>
        <h5>Available books</h5>
        <pre>
{{availableBooks}}
        </pre>
        <hr>
        <pre>
{{book}}
        </pre>
        <router-link :to="`/books/${book_id}/edit`">edit</router-link>
        <button @click="delete_book">delete</button>
        {{errors}}
    </div>
</template>

<script>
export default {
    name: 'book',
    data(){
        return {
            book_id: this.$route.params.id,
            book: {},
            errors: null
        }
    },
    methods: {
        delete_book(){
            if(window.confirm("Are you sure you want to delete this item?\nThis action cannot be undone!")){
                axios.delete(`/api/books/${this.book_id}`)
                    .then((res, rej) => {
                        alert('deleted');
                        this.$router.push('/books');
                    });
            }
        }
    },
    computed: {
        availableBooks(){
            if(this.book.books)
                return this.book.books.filter(book => {
                    return book.availability === 'available';
                });
        }
    },
    created(){
        let book = axios.get(`/api/books/${this.book_id}`)
            .then((res, rej) => {
                this.book = res.data.book;
            })
            .catch(err => {
                console.log(err.response);
                if(err.response.status == 404){
                    this.errors = "Book is either deleted or never exists";
                } else if(err.response.status == 500) {
                    this.errors = "The server is unavailable at this time.";
                } else {
                    this.errors = err.response.data.message;
                }
            });
    }
}
</script>
