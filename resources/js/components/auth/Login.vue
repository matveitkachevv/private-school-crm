<template>
    <div class="d-flex align-center justify-center" style="height: 100vh">
        <v-sheet width="600" class="mx-auto main-form">
            <v-form fast-fail @submit.prevent="login">
                <v-text-field v-model="username" label="Логин"/>
                <v-text-field
                    :append-icon="value ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                    :type="value ? 'password' : 'text'"
                    @click:append="() => (value = !value)"
                    v-model="password"
                    label="Пароль"/>
                <v-btn
                    type="submit"
                    color="blue"
                    block
                    height="50"
                >Авторизоваться</v-btn>
            </v-form>
        </v-sheet>
    </div>
</template>

<script>
export default {
    name: 'LoginComponent',
    data() {
        return {
            username: '',
            password: '',
            value: false
        };
    },
    methods: {
        login() {
            axios({
                method: 'post',
                url: '/login',
                data: {
                    name: this.username,
                    password: this.password
                }
            }).then(() => {
                location.reload();
            });
        },
    },
}
</script>

<style scoped>
.main-form{
    padding: 60px;
    border-radius: 7px;
}
</style>
