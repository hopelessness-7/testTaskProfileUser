<template>
    <div class="q-pa-md flex flex-center" style="height: 100vh; background: linear-gradient(to right, #6a3093, #a044ff, #c471ed, #fa71cd);">
        <div class="row justify-center q-card q-pa-md" style="width: 60%; height: 80%">
            <div class="col-6 flex flex-center">
                <div class="text-center" style="width: 100%">
                    <div class="text-h4 q-mb-md">Авторизация</div>
                    <q-form class="">
                        <q-input class="col-8 q-mb-md" filled v-model="email" label="Email" />
                        <q-input class="q-mb-md" filled v-model="password" label="Пароль" type="password" />
                        <div class="row items-center q-mb-md">
                            <q-btn label="Войти" class="q-mr-md" color="primary" @click="login"/>
                            <q-btn label="Регистрация" color="secondary" to="/register"/>
                        </div>
                    </q-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        login() {
            const dataPost = { email: this.email, password: this.password };
            axios.post('/api/v1/login', dataPost).then((response) => {
                localStorage.setItem('token', response.data.data.token);
                window.location.href = '/profile';
            }).catch((error) => {
                // Handle registration errors
            });
        }
    }
};
</script>
<style>
.my_card {
    width: 25rem;
    border-radius: 8px;
    box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}
</style>
