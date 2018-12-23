<template>
    <div class="container">
        <h3>OAuth</h3>
        <login></login>
    </div>
</template>

<script>

import login from './login';

export default {
    name: 'oauth',
    components: {
        login
    }
}
</script>
