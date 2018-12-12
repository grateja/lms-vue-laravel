<template>
    <div class="autocomplete">
        <input type="text" @input="search($event.target.value)" :id="id" :value="value" ref="keyword" :class="class_name" @blur="blur" autocomplete="off" @keydown="keydown">
        {{selectedIndex}}
        <ul v-if="items.length > 0">
            <li v-for="(item, i) in items" :key="item[data_field]" @click="select(item)" :class="{active: i == selectedIndex}" >{{item[data_display]}}</li>
            <slot name="footer"></slot>
        </ul>
    </div>
</template>

<script>
export default {
    props:{
        url: {},
        id: {},
        data_source: {},
        data_field: {},
        data_display: {},
        class_name: {
            default: 'form-control'
        },
        value: {}
    },
    name: 'autocomplete',
    data(){
        return {
            items: [],
            selectedIndex: -1
        }
    },
    methods: {
        search(val){
            this.$emit('input', val);
            if(val.length > 0){
                axios.get(this.url, {
                    params: {keyword: val}
                }).then((res, rej) => {
                    this.items = res.data[this.data_source];
                });
            } else {
                this.items = [];
            }
        },
        select(item){
            this.items = [];
            this.$refs.keyword.focus();
            this.$emit('select', item);
            this.$emit('input', item[this.data_display]);
            this.selectedIndex = -1;
        },
        blur(){
            setTimeout(() => {
                this.items = [];
            }, 500);
        },
        keydown(event){
            if(this.items.length == 0) return;

            let keys = [40, 38, 27, 13];

            if(keys.includes(event.which)){

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
                    case 13:
                        // enter
                        this.select(this.items[this.selectedIndex]);
                        event.preventDefault();
                        return;
                        break;
                    default:
                        break;
                }
                this.navigate(this.items[this.selectedIndex])
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
        color:red;
        background: silver;
    }
</style>
