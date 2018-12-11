<template>
    <div class="autocomplete">
        <input type="text" @input="update($event.target.value)" ref="input" > {{initial_value}}
        <ul v-show="items.length > 0">
            <li v-for="item in items" :key="item[data_field]" @click="select(item)">{{item[data_display]}}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props:
        ['url',
        'data_source',
        'data_field',
        'data_display',
        'class_name',
        'value',
        'initial_value']
    ,
    name: 'autocomplete',
    data(){
        return {
            focused: false,
            items:[]
            // content: this.value
        }
    },
    // props: ['url', 'data_source', 'data_field', 'data_display', 'class_name', 'value'],
    methods: {
        search(val){
            console.log(val)
            // this.$emit('input', this.keyword);
            if(val){
                axios.get(this.url, {
                    params: {keyword: val}
                }).then((res, rej) => {

                    this.items = res.data[this.data_source];
                });
            } else {
                // this.items = [];
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
        },
        update(val){
            console.log(this.$refs.input.value)
            if(val == 'keme')
                this.some = 'wala';
            if(val){
                axios.get(this.url, {
                    params: {keyword: val}
                }).then((res, rej) => {
                    // this.getItems = res.data[this.data_source];
                    this.$emit('show', res.data[this.data_source]);
                    this.items = res.data[this.data_source];
                    // console.log(res.data[this.data_source]);
                });
            } else {
                // this.items = [];
            }
            console.log(this.value)
            this.$emit('input', this.value);
        }
    },
    computed: {
        getItems(){
            return {
                get(){
                    return this.items;
                },
                set(value){
                    console.log('value', value);
                    this.items = value;
                }
            }
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
        z-index: 9999;
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
