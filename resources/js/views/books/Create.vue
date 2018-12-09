<template>
    <div class="create-book">
        <h3>Create new book</h3>

        <div class="create-book-container">
            <form method="POST" @submit.prevent="save" @keypress="errors.clear($event.target.id)">

                <div class="form-group">
                    <label for="price">Price :</label>
                    <input type="number" id="price" class="form-control" v-model="book.price">
                    <span class="text-danger" v-show="errors.has('price')" v-text="errors.get('price')"></span>
                </div>

                <div class="form-group">
                    <label for="type_id">Type ID :</label>
                    <input type="text" id="type_id" class="form-control" v-model="book.type_id">
                    <span class="text-danger" v-show="errors.has('type_id')" v-text="errors.get('type_id')"></span>
                </div>

                <div class="form-group">
                    <label for="title">Title :</label>
                    <input type="text" id="title" class="form-control" v-model="book.title">
                    <span class="text-danger" v-show="errors.has('title')" v-text="errors.get('title')"></span>
                </div>

                <div class="form-group">
                    <label for="author">Author :</label>
                    <input type="text" id="author" class="form-control" v-model="book.author">
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN :</label>
                    <input type="text" id="isbn" class="form-control" v-model="book.isbn">
                </div>

                <div class="form-group">
                    <label for="year_published">Year published :</label>
                    <input type="text" id="year_published" class="form-control" v-model="book.year_published">
                    <span class="text-danger" v-show="errors.has('year_published')" v-text="errors.get('year_published')"></span>
                </div>

                <div class="form-group">
                    <label for="edition">Edition :</label>
                    <input type="text" id="edition" class="form-control" v-model="book.edition">
                </div>

                <div class="form-group">
                    <label for="volume">Volume :</label>
                    <input type="text" id="volume" class="form-control" v-model="book.volume">
                </div>

                <div class="form-group">
                    <label for="publisher">Publisher :</label>
                    <input type="text" id="publisher" class="form-control" v-model="book.publisher.name" @keyup="searchPublisher" autocomplete="off">
                    <div class="publisher-dropdown" v-show="publishers.length > 0">
                        <ul>
                            <li v-for="(pub, i) in publishers" :key="i" v-text="pub.name" @click="selectPublisher(pub)"></li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="publishing_place">Publishing Place :</label>
                    <input type="text" id="publisher" class="form-control" v-model="book.publishing_place.name" @keyup="searchPublishingPlace" autocomplete="off">

                    <div class="publishing-place-dropdown" v-show="publishing_places.length > 0">
                        <ul>
                            <li v-for="(pub, i) in publishing_places" :key="i" v-text="pub.name" @click="selectPublishingPlace(pub)"></li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dewey">Dewey :</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <input type="text" id="decimal" v-model="book.dewey.decimal" class="form-control" @keyup="searchDewey($event.target.value)" autocomplete="off">
                        </div>
                        
                        <div class="col-sm-4">
                            <input type="text" id="classification" v-model="book.dewey.classification" class="form-control" @keyup="searchDewey($event.target.value)" autocomplete="off">
                        </div>

                        <div class="col-sm-6">
                            <input type="text" id="description" v-model="book.dewey.description" class="form-control" disabled>
                        </div>
                    </div>
                    <ul v-show="deweys.length > 0">
                        <li v-for="(d, i) in deweys" :key="i" v-text="`${d.decimal} - ${d.classification}`" @click="selectDewey(d)"></li>
                    </ul>
                </div>

                <div class="form-group">
                    <input type="submit" value="Save" class="btn btn-primary">
                </div>

            </form>
        </div>

        <router-link to="/books">Cancel</router-link>
    </div>
</template>

<script>
import FormHelpers from '../../helpers/FormHelpers.js';

export default {
    name: 'create-book',
    data() {
        return {
            book: {
                publisher: {},
                publishing_place: {},
                dewey: {}
            },
            publishers: [],
            publishing_places: [],
            deweys: [],
            dewey: '',
            errors: FormHelpers
        }
    },
    methods: {
        save(){
            let id = this.$route.params.id
            let action = id ? 'put' : 'post';
            let url = id ? `/api/books/${id}` : '/api/books'

            axios[action](url,
                this.book,
            ).then((res, rej) => {
                this.$router.push(`/books/${res.data.book.id}`);
            }).catch(err => {
                this.errors.errors = err.response.data.errors;
            });
        },
        searchPublisher(){
            if(this.book.publisher){
                this.book.publisher_id = null;
                axios.get('/api/publishers', {
                    params: {keyword: this.book.publisher.name}
                }).then((res, rej) => {
                    this.publishers = res.data.publishers;
                });
            } else {
                this.publishers = [];
            }
        },
        selectPublisher(publisher){
            this.book.publisher_id = publisher.id;
            this.book.publisher = publisher;
            this.publishers = [];
        },
        searchPublishingPlace(){
            if(this.book.publishing_place){
                this.book.publishing_place_id = null;
                axios.get('/api/publishing-places', {
                    params: {keyword: this.book.publishing_place.name}
                }).then((res, rej) => {
                    this.publishing_places = res.data.publishing_places;
                });
            } else {
                this.publishing_places = [];
            }
        },
        selectPublishingPlace(place){
            this.book.publishing_place_id = place.id;
            this.book.publishing_place = place;
            this.publishing_places = [];
        },
        searchDewey(keyword){
            if(keyword.length > 0){
                this.book.dewey_id = null;
                axios.get('/api/deweys', {
                    params: {keyword: keyword}
                }).then((res, rej) => {
                    console.log(res.data);
                    this.deweys = res.data.deweys;
                })
            } else {
                this.dewey = [];
            }
        },
        selectDewey(dewey) {
            this.book.dewey_id = dewey.id;
            this.book.dewey = dewey;
            this.deweys = [];
        }
    },
    created(){
        if(this.$route.params.id){
            let book = axios.get(`/api/books/${this.$route.params.id}`)
                .then((res, rej) => {
                    this.book = res.data.book;
                    if(!this.book.publisher)
                        this.book.publisher = {};
                    
                    if(!this.book.publishing_place)
                        this.book.publishing_place = {};
                    
                    if(!this.book.dewey)
                        this.book.dewey = {};
                });
        }
    }
}
</script>
