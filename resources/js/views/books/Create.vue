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

                    <autocomplete v-model="book.publisher.name" url="/api/autocomplete/publishers" data_source="publishers"></autocomplete>
                    <li slot="footer"><router-link to="/publishers">Manage publishers</router-link></li>
                </div>

                <div class="form-group">
                    <label for="publishing_place">Publishing Place :</label>

                    <autocomplete v-model="book.publishing_place.name" url="/api/publishing-places" data_source="publishing_places"></autocomplete>
                </div>

                <div class="form-group">
                    <label for="dewey">Dewey :</label>

                    <autocomplete v-model="book.dewey.display" url="/api/autocomplete/deweys" data_source="deweys" data_display="display" @select="selectDewey">
                        <li class="link" slot="link"><router-link to="/deweys">Manage dewey decimals</router-link></li>
                    </autocomplete>
                </div>

                <div class="form-group">
                    <label for="categories">Categories :</label>
                    <div class="categories">
                        <ul v-if="book.categories && book.categories.length > 0">
                            <li class="category" v-for="cat in book.categories" :key="cat.id" :data-keme="cat.id">{{cat.name}}
                                <button type="button" class="btn btn-default btn-xs" @click="removeCategory(cat)">remove</button>
                            </li>
                        </ul>
                    </div>

                    <autocomplete v-model="category" url="/api/autocomplete/categories" @select="selectCategory" data_source="categories">
                        <li slot="link"><router-link tabindex="-1" to="/categories">Manage categories</router-link></li>
                    </autocomplete>

                    <!-- <input type="text" id="category" class="form-control" v-model="category" @keyup="searchCategories" ref="category" autocomplete="off">
                    <ul v-show="categories.length > 0">
                        <li v-for="cat in categories" :key="cat.id" v-text="cat.name" @click="selectCategory(cat)" :class="cat.isSelected ? 'active' : ''"></li>
                    </ul>
                    <router-link to="/categories">Manage categories</router-link> -->
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
import autocomplete from '../../components/Autocomplete.vue';

export default {
    name: 'create-book',
    components: {
        autocomplete
    },
    data() {
        return {
            book: {
                publisher: {},
                publishing_place: {},
                dewey: {},
                selected_category_ids: []
            },
            // selectedCategories: [],
            publishers: [],
            publishing_places: [],
            deweys: [],
            dewey: '',
            categories: [],
            category: '',
            errors: FormHelpers,
            keme: 'sometext',
            list: []
        }
    },
    methods: {
        save(){
            let id = this.$route.params.id
            let action = id ? 'put' : 'post';
            let url = id ? `/api/books/${id}` : '/api/books'

            // this.book.selected_category_ids = this.selectedCategoriesIDs();

            this.book.publisher_name = this.book.publisher.name;
            this.book.publishing_place_name = this.book.publishing_place.name;

            console.log('before save', this.book);

            axios[action](url,
                this.book,
            ).then((res, rej) => {
                console.log(res.data);
                // this.$router.push(`/books/${res.data.book.id}`);
            }).catch(err => {
                this.errors.errors = err.response.data.errors;
            });
        },
        selectDewey(dewey){
            if(dewey && typeof dewey === "object"){
                this.book.dewey = dewey;
                this.book.dewey_id = dewey.id;
            } else {
                this.book.dewey = {display: dewey};
            }
        },
        // searchCategories(){
        //     if(this.category.length > 0){
        //         axios.get('/api/categories', {
        //             params: {keyword: this.category}
        //         }).then((res, rej) => {
        //             this.categories = res.data.categories.map(cat => {
        //                 cat.isSelected = this.selectedCategories.filter(c => c.id == cat.id).length > 0;
        //                 return cat;
        //             });
        //         })
        //     } else {
        //         this.categories = [];
        //     }
        // },
        selectCategory(cat){

            if(!cat) return;

            if(typeof cat === "string"){
                cat = {name: cat};
            }

            if(!this.book.categories){
                this.book.categories = [cat];
                this.category = '';
                return;
            }

            if(this.book.categories.filter(c => {return c.name == cat.name}).length > 0){
                return;
            }

            this.book.categories.push(cat);
            this.category = '';
        },
        removeCategory(cat){
            this.book.categories = this.book.categories.filter(c => {
                return c != cat;
            });
        },
        selectedCategoriesIDs(){
            return this.book.categories.map(c => {return c.id});
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
                    
                    if(!this.book.categories)
                        this.book.categories = [];

                    // this.selectedCategories = this.book.categories;
                });
        }
    }
}
</script>

<style scoped>
    .category{
        display: inline-block;
    }
    li.active{
        color: red;
    }
</style>
