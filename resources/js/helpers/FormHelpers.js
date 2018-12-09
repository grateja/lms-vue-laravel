class FormHelper{
    constructor(){
        this.errors = {};
    }

    messages(){
        return this.errors;
    }

    any(){
        return Object.keys(this.errors).length > 0;
    }

    get(key){
        if(this.errors && this.errors[key])
            return this.errors[key][0];
    }

    has(key){
        if(this.errors)
            return this.errors.hasOwnProperty(key);
    }

    clear(key){
        if(!key){
            this.errors = {};
            return;
        }

        if(this.errors && this.errors[key]){
            delete this.errors[key];
        }
    }
}

export default new FormHelper({

});