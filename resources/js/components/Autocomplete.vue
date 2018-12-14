<template>
    <div class="autocomplete">
        {{typing}}
        <input type="text" @input="search($event.target.value)" :id="id" :value="value" ref="keyword" :class="class_name" @blur="blur" autocomplete="off" @keyup="keyup" @keydown.enter.prevent="keydown">
        <ul v-if="(items.length > 0) && !typing">
            <li v-for="(item, i) in items" :key="item[data_field]" @click="select(item)" :class="{active: i == selectedIndex}" >{{item[data_display]}}</li>
            <slot name="link"></slot>
        </ul>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props:{
        url: {},
        id: {},
        data_source: {},
        data_field: {
            default: 'id'
        },
        data_display: {
            default: 'name'
        },
        class_name: {
            default: 'form-control'
        },
        value: {}
    },
    name: 'autocomplete',
    data(){
        return {
            items: [],
            selectedIndex: -1,
            oldval:'',
            cancelSource: null,
            typing: false
        }
    },
    methods: {
        search(val){
            this.$emit('input', val);

            if(this.oldval != val) {
                this.oldval = val;
            } else {
                return;
            }

            this.cancelSearch();
            this.cancelSource = axios.CancelToken.source();

            if(val.length > 0){
                axios.get(this.url, {
                    params: {keyword: val},
                    cancelToken: this.cancelSource.token
                }).then((res, rej) => {
                    this.items = res.data[this.data_source];
                }).catch(err => {
                    // console.log(err);
                });
            } else {
                this.items = [];
            }
        },
        cancelSearch(){
            if(this.cancelSource){
                this.cancelSource.cancel();
            }
        },
        select(item){
            this.cancelSearch();
            this.items = [];
            this.selectedIndex = -1;
            this.$refs.keyword.focus();
            this.$emit('input', item[this.data_display]);
            this.$emit('select', item);
        },
        blur(){
            this.cancelSearch();
            setTimeout(() => {
                this.items = [];
                this.selectedIndex = -1;
            }, 200);
        },
        keyup(event){
            console.log(event.which);
            let keys = [40, 38, 27];

            if(keys.includes(event.which)){
                if(this.items.length == 0){
                    return;
                }
                switch (event.which) {
                    case 40:
                        // key down
                        this.selectedIndex += this.selectedIndex < this.items.length -  1 ? 1 : 0;
                        event.preventDefault();
                        break;
                    case 38:
                        // key up
                        this.selectedIndex -= this.selectedIndex > 0 ? 1 : 0;
                        event.preventDefault();
                        break;
                    case 27:
                        // escape
                        this.items = [];
                        this.$emit('input', '');
                        this.selectedIndex = -1;
                        event.preventDefault();
                        return;
                        break;
                    default:
                        break;
                }
                this.navigate(this.items[this.selectedIndex])
            } else {
                this.items = [];
                this.typing = true;
                setTimeout(() => {
                    this.typing = false;
                }, 300);
            }
        },
        keydown(){
            if(this.items.length > 0 && this.selectedIndex > 0){
                this.select(this.items[this.selectedIndex]);
            } else {
                this.$emit('select', this.value);
                this.items = [];
            }
        },
        navigate(item){
            this.$emit('input', item[this.data_display]);
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
    li.active{
        color:rgb(0, 153, 255);
        background: rgb(229, 255, 255);
    }
    li.link:last-child{
        font-weight: bold;
        border-top: 1px solid silver;
    }
</style>
