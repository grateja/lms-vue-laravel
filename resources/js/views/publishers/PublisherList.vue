<template>
    <div class="publishers">
        <div class="container">

            <h3>Publishers</h3>
            <hr>
            <a href="#" @click.prevent="publisher = publisher? null : {}" v-text="isEditMode ? 'Cancel' : 'Create new'"></a>

            <publisherForm v-show="isEditMode" :publisher="publisher"></publisherForm>

            <ul>
                <li v-for="pub in publishers" :key="pub.id">
                    <div>
                        <h5 @click.prevent="edit(pub)">{{ pub.name }}</h5>
                        <p>{{ pub.description }}</p>
                    </div>
                </li>
            </ul>

            <pager :total_pages="total_page" uri="/publishers" @navigate="navigate"></pager>
        </div>
    </div>
</template>

<script>
import pager from '../../components/Pager.vue';
import publisherForm from './Create.vue';

export default {
    name: 'publishers-list',
    components: {
        pager,
        publisherForm
    },
    data(){
        return {
            publishers:[],
            publisher: null,
            keyword: '',
            total_page: 0,
            current_page: this.$route.query.page
        }
    },
    methods: {
        filter(){
            axios.get('/api/publishers', {
                params: {keyword: this.keyword, page: this.current_page}
            }).then((res, rej) => {
                console.log(res.data.data)
                this.publishers = res.data.data.data;
                this.total_page = res.data.data.last_page;
            });
        },
        load() {
            this.filter();
        },
        edit(pub){
            this.isEditMode = true;
            this.publisher = pub;
        },
        navigate(page){
            this.current_page = page;
            this.filter();
        }
    },
    computed: {
        isEditMode(){
            return this.publisher != null;
        }
    },
    created(){
        this.load();
    }
}
</script>

