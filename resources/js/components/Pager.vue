<template>
    <ul class="pagination pagination-sm" v-show="total_pages > 1">
        <li v-for="page in total_pages" :key="page" :class="{active: ($route.query.page == page) || (!$route.query.page && page == 1)}" class="page-item">
            <a href="#" @click.prevent="navigate(page)" class="page-link">{{page}}</a>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'pager',
    props: {
        total_pages: {
            required: true,
            dataType: 'integer'
        },
        uri: {
            required: true
        }
    },
    methods: {
        navigate(page){
            this.$emit('beforeNavigate', page);
            this.$router.push(`${this.uri}?page=${page}`);
            this.$emit('navigate', page);
        }
    }
}
</script>

