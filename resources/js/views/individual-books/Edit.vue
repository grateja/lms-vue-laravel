<template>
    <div class="individual-book-edit" @click="close($event)">
        <div class="edit-book">
            <form method="POST" @submit.prevent="save">
                <div class="form-group">
                    <label for="unique_id">Unique ID:</label>
                    <input type="number" id="unique_id" class="form-control input-sm" v-model="raw_book.unique_id">
                </div>

                <div class="form-group">
                    <label for="condition">Condition:</label>
                    <select id="condition" class="form-control" v-model="raw_book.condition_id">
                        <option :value="null">-N/A-</option>
                        <option :value="condition.id" v-for="condition in book_conditions" :key="condition.id">{{condition.name}}</option>
                    </select>
                    <label for="apply_all_condition">
                        <input type="checkbox" id="apply_all_condition" v-model="apply_all_condition">
                        Apply to all
                    </label>
                </div>

                <div class="form-grou">
                    <input type="submit" value="Save" class="btn btn-primary btn-sm">
                </div>
            </form>
            {{book}}
        </div>
    </div>
</template>

<script>
export default {
    name: 'individual-book-edit',
    props: ['book','book_conditions'],
    data() {
        return {
            raw_book: Object.assign({}, this.book),
            apply_all_condition: false
        }
    },
    methods: {
        close(e) {
            if(this.$el == e.target){
                this.$emit('close');
            }
        },
        save(){
            this.raw_book.apply_all_condition = this.apply_all_condition;
            axios.patch(`/api/individual-books/${this.book.id}`, this.raw_book).then((res) => {
                this.$emit('save', res.data.book);
            });
        }
    },
    created() {
    }
}
</script>

<style>
    .individual-book-edit{
        background: rgba(0, 0, 0, 0.123);
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        overflow-y: scroll;
    }
    .edit-book{
        background:white;
        box-shadow: 10px 10px 40px rgba(0, 0, 0, 0.301);
        max-width: 400px;
        margin: 30px auto;
        padding: 20px;
    }
</style>
