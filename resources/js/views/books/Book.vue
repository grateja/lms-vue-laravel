<template>
    <div class="book">
        <h3>This is a fucking book</h3>
        <pre>
{{book}}
        </pre>
        <router-link :to="`/books/${book_id}/edit`">edit</router-link>
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
