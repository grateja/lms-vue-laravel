<template>
    <div class="view-all">
        {{keyword}}
        <pre>
{{books}}
        </pre>
    </div>
</template>
<script>
export default {
    name: 'view-all',
    data() {
        return {
            book_id: this.$route.params.id,
            books: null,
            keyword: this.$route.query.keyword
        }
    },
    created(){
        axios.get(`/api/individual-books/${this.book_id}`,{
            params: {
                keyword: this.keyword
            }
        }).then((res, rej) => {
            console.log(res)
            this.books = res.data.books;
        });
    }
}
</script>
