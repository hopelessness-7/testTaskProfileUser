<template>
    <div class="q-pa-md flex flex-center" style="height: 100vh; background: linear-gradient(to right, #6a3093, #a044ff, #c471ed, #fa71cd);">
        <div class="row justify-center q-card q-pa-md" style="width: 60%; height: 80%">
            <div class="col-6 flex flex-center">
                <div class="text-center" style="width: 100%">
                    <div class="text-h4 q-mb-md">Регистрация</div>
                    <q-form class="">
                        <q-input class="col-8 q-mb-md" filled v-model="name" label="Имя" />
                        <q-input class="col-8 q-mb-md" filled v-model="phone" label="Номер телефона" />
                        <q-input class="col-8 q-mb-md" filled v-model="email" label="Email" type="email" />
                        <q-input class="q-mb-md" filled v-model="password" label="Пароль" type="password" />
                        <q-input class="q-mb-md" filled v-model="confirm_password" label="Потверждение пароля" type="password" />
                        <div class="row items-center q-mb-md">
                            <q-btn label="Регистрация" class="q-mr-md" color="primary" @click="register"/>
                            <q-btn label="Войти в существующий аккаунт" color="secondary" to="/login"/>
                        </div>
                        <div class="text-left"><a href="/password-recovery">Забыли пароль?</a></div>
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
            name: '',
            email: '',
            password: '',
            confirm_password: '',
            phone: '',
        };
    },
    methods: {
        register() {
            const dataPost = { email: this.email, name: this.name, phone: this.phone, password: this.password, confirm_password: this.confirm_password, confirmation_type: 'email'  };
            axios.post('/api/v1/register', dataPost).then((response) => {
                localStorage.setItem('token', response.data.data.token);
                window.location.href = '/profile';
            }).catch((error) => {
                // Handle registration errors
            });
        }
    }
};
</script>
