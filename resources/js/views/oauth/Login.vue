<template>
    <div class="login">
        <form method="POST" @submit.prevent="login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" class="form-control input-sm" v-model="credentials.email">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" class="form-control input-sm" v-model="credentials.password">
            </div>

            <div class="form-group">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'login',
    data() {
        return {
            credentials: {
                email:'',
                password:''
            }
        }
    },
    methods: {
        login(){
            axios.post('/api/auth/login', this.credentials).then((res) => {
                localStorage.setItem('token', res.data.access_token)
                console.log(res);
            }).catch(err => {
                console.log(err)
            })
        }
    }
}
</script>
