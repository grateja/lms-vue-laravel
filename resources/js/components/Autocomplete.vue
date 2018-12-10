<template>
    <div class="autocomplete">
        <input type="text" @keyup="search" v-model="keyword" ref="keyword" :class="class_name" @blur="blur">
        <ul v-show="items.length > 0">
            <li v-for="item in items" :key="item[data_field]" @click="select(item)">{{item[data_display]}}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'autocomplete',
    data(){
        return {
            keyword: '',
            items: []
        }
    },
    props: ['url', 'data_source', 'data_field', 'data_display', 'class_name'],
    methods: {
        search(){
            if(this.keyword.length > 0){
                axios.get(this.url, {
                    params: {keyword: this.keyword}
                }).then((res, rej) => {
                    this.items = res.data[this.data_source];
                })
            } else {
                this.items = [];
            }
        },
        select(item){
            this.items = [];
            this.$refs.keyword.focus();
            this.keyword = item[this.data_display];
            this.$emit('select', item);
        },
        blur(){
            setTimeout(() => {
                this.items = [];
            }, 500);
        }
    }
}
</script>

<style scoped>
    .autocomplete{
        position: relative;
    }
    .autocomplete ul{
        background: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.418);
        border-radius: 5px;
        list-style: none;
        position: absolute;
        margin: 0px;
        padding: 0px;
    }
    li{
        border: 1px solid rgb(243, 243, 243);
        cursor: default;
        list-style: none;
        margin: 0px;
        padding: 5px 20px;
    }
    li:last-child{
        border-radius: 0px 0px 5px 5px;
    }
    li:first-child{
        border-radius: 5px 5px 0px 0px;
    }
    li:hover{
        color: rgb(0, 153, 255);
    }
</style>
