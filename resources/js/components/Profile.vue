<template>
    <div class="q-pa-md flex flex-center" style="height: 100vh; background: linear-gradient(to right, #6a3093, #a044ff, #c471ed, #fa71cd);">
        <div class="row q-card q-pa-md" style="width: 85%; height: 85%">
            <div class="col-12 text-center text-h4">Профиль</div>
            <div class="flex justify-center" style="width: 100%">
                <div class="row col-12 q-mr-lg rounded-borders" style="width: 35%; height: 73vh">
                    <q-card class="q-mt-xl col-12" style="background-color: #87CEEB">
                        <q-card-section class="col-12 flex column justify-center items-center" style="height: 40%">
                            <div><q-avatar class="col-12" rounded size="100px" font-size="82px" color="blue" text-color="white" icon="T" style="margin: 0 auto;" /></div>
                            <div><q-badge color="black" class="col-12">User Default</q-badge></div>
                        </q-card-section>
                        <q-separator style="width: 100%;" color="black"/>
                        <q-card-section>
                            <div class="text-justify text-h5">Данные</div>
                            <q-list class="text-justify q-mt-lg" style="font-size: 16px">
                                <q-item>ФИО: {{ user.name }}</q-item>
                                <q-item>Номер телефона: {{ user.phone }}</q-item>
                                <q-item>email: {{ user.email }}</q-item>
                                <q-item>Телеграмм ID: {{ user.telegram_id }}</q-item>
                                <q-item>Тип потверждения: {{user.confirmation_type}}</q-item>
                                <q-item>
                                    <q-btn label="Обновить" class="q-my-sm col-2" color="primary" @click="editProfile = true" />
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
                <div class="row q-mt-xl col-12 rounded-borders" style="width: 63%; height: 68vh">
                    <div class="col-12 row" style="height: 48%;">
                        <q-card class="col-12" style="height: 100%; background-color: #87CEEB">
                            <q-card-section class="col-12">
                                <div class="text-justify q-ml-sm q-mt-sm text-h5">Изменить пароль</div>
                            </q-card-section>
                            <q-card-section class="col-12">
                                <div class="bg-warning q-px-lg q-py-lg rounded-borders">
                                    Убедитесь, что эти требования соблюдены!
                                    Минимум 8 символов для пароля
                                </div>
                            </q-card-section>
                            <q-card-section class="col-12 row" style="width: 100%">
                                <q-input v-model="password" type="password" label="Новый пароль" class="q-mr-lg" filled dense style="width: 49%" />
                                <q-input v-model="confirmPassword" type="password" label="Потверждение" class="" filled dense style="width: 49%"/>
                                <q-btn label="Обновить" class="q-mt-md col-12" color="primary" @click="confirmSendCode('updatePassword')" />
                            </q-card-section>
                        </q-card>
                    </div>
                    <div class="col-12" style="height: 48%;">
                        <q-card class="col-12" style="height: 100%; background-color: #87CEEB">
                            <q-card-section class="col-12">
                                <div class="text-justify q-ml-sm q-mt-sm text-h5">Потверждение данных через</div>
                            </q-card-section>
                            <q-card-section class="col-12 row" style="width: 100%">
                                <q-radio v-model="typeConfirm" val="sms" label="СМС" color="teal" class="col-12" />
                                <q-radio v-model="typeConfirm" val="telegram" label="Telegram" color="orange" class="col-12" />
                                <q-radio v-model="typeConfirm" val="email" label="Email" color="red" class="col-12" />
                                <q-btn label="Обновить" class="q-mt-md col-12" color="primary" @click="confirmSendCode('updateTypeConfirm')" />
                            </q-card-section>
                        </q-card>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <q-dialog v-model="isOpenConfirmCode">
        <q-card>
            <q-card-section>
                <div class="text-h6">Введите код подтверждения</div>
            </q-card-section>

            <q-card-section>
                <q-input v-model="codeConfirmation" label="Код подтверждения" />
            </q-card-section>

            <q-card-actions align="right">
                <q-btn flat label="Отмена" v-close-popup />
                <q-btn flat label="Подтвердить" v-close-popup @click="confirmCheckCode" />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-dialog v-model="editProfile">
        <q-card>
            <q-card-section>
                <div class="text-h6">Редактирование данных</div>
            </q-card-section>

            <q-card-section>
                <q-input v-model="user.name" label="ФИО" />
                <q-input v-model="user.phone" label="Номер телефона" />
                <q-input v-model="user.email" label="Email" />
                <q-input v-model="user.telegram_id" label="Телеграмм ID" />
            </q-card-section>

            <q-card-actions align="right">
                <q-btn flat label="Отмена" v-close-popup />
                <q-btn flat label="Сохранить" @click="confirmSendCode('updateDataUser')" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            token: localStorage.getItem('token'),
            typeConfirm: '',
            password: '',
            confirmPassword: '',
            user: {},
            codeConfirmation: '',
            typeOperation: '',
            isOpenConfirmCode:false,
            editProfile: false,
        };
    },
    mounted() {
        this.getDataUser();
    },
    methods: {
        getDataUser() {
            axios.get('/api/v1/user', {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            }).then((response) => {
                this.user = response.data.data;
                this.typeConfirm = this.user.confirmation_type; // Устанавливаем значение typeConfirm
            }).catch((error) => {
                console.error('Error fetching user data:', error);
            });
        },
        editConfirmationType() {
            axios.patch(`/api/v1/users/update/${this.user.id}`,
                {
                    confirmation_type: this.typeConfirm
                },
                {
                    headers: {'Authorization': `Bearer ${this.token}`}
                }
            ).then((response) => {
                this.getDataUser();
            }).catch((error) => {

            })
        },
        editDataUser() {
            axios.patch(`/api/v1/users/update/${this.user.id}`, this.user, {
                headers: {'Authorization': `Bearer ${this.token}`}
            }).then((response) => {
                this.getDataUser();
                this.editProfile = false;
            }).catch((error) => {

            })
        },
        editPassword() {
            axios.patch(`/api/v1/users/update/${this.user.id}`,
                {
                    password: this.password,
                    confirm_password: this.confirmPassword
                },
                {
                    headers: {'Authorization': `Bearer ${this.token}`}
                }
            ).then((response) => {
                this.getDataUser();
            }).catch((error) => {

            })
        },
        confirmSendCode(type) {
            if (type === 'updatePassword'){
                if (this.password !== this.confirmPassword) {
                    alert('Пароли не совпадают!')
                }
            }
            axios.post(`/api/v1/confirmation/send`,
                {
                    type: this.user.confirmation_type
                },
                {
                    headers: {'Authorization': `Bearer ${this.token}`}
                }
            ).then((response) => {
                this.typeOperation = type;
                this.isOpenConfirmCode = true;
            }).catch((error) => {

            })
        },
        confirmCheckCode() {
            axios.post(`/api/v1/confirmation/check`,
                {
                    code: this.codeConfirmation
                },
                {
                    headers: {'Authorization': `Bearer ${this.token}`}
                }
            ).then((response) => {
                if (this.typeOperation === 'updateTypeConfirm') {
                    this.editConfirmationType();
                } else if (this.typeOperation === 'updatePassword') {
                    this.editPassword();
                } else if (this.typeOperation === 'updateDataUser') {
                    this.editDataUser();
                }
                this.isOpenConfirmCode = false;
                this.codeConfirmation = '';
            }).catch((error) => {

            })
        }

    }
};
</script>
