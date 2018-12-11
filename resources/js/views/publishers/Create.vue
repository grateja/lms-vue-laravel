<template>
    <div class="publisher">
        <form @submit.prevent="save">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" v-model="publisher.name" id="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" v-model="publisher.description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <input type="submit" value="Save" class="btn btn-primary">
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'publisher-form',
    props: {
        publisher: {}
    },
    data(){
        return {
        }
    },
    methods: {
        save(){
            axios.post('/api/publishers',
                this.publisher
            ).then((res, rej) => {

                this.$emit('saved', res.data);
            });
        }
    }
}
</script>
