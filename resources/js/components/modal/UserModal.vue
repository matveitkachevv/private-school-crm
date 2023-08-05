<template>
    <v-row justify="center" >
        <v-dialog
            v-model="dialog"
        >
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                >
                    Добавить нового ученика
                </v-btn>
            </template>
            <v-card max-width="800px">
                <v-card-title>
                    <span class="text-h5">Новый ученик</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                            >
                                <v-text-field
                                    label="ФИО ученика*"
                                    v-model="student.name"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                            >
                                <v-text-field
                                    label="Номер телефона"
                                    v-model="student.phone"
                                    :counter="11"
                                    :rules="phoneRules"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                            >
                                <v-textarea
                                    label="Комментарий"
                                    v-model="student.comment"
                                    required
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>* - Обязательные поля</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="green-darken-1"
                        variant="text"
                        @click="dialog = false"
                    >
                        Закрыть
                    </v-btn>
                    <v-btn
                        color="green-darken-1"
                        variant="text"
                        @click="send()"
                    >
                        Добавить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>

export default {
    name: 'UserModalComponent',
    data: () => ({
        dialog: false,
        student: {
            name: '',
            phone: null,
            comment: null
        },
        phoneRules: [
            value => {
                if (value?.length > 10 && /[0-9-]+/.test(value)) return true
                return 'Номер телефона должен состоять из 11 цифр'
            }
        ],
    }),
    mounted(){
    },
    methods: {
        send(){
            axios({
               method: 'post',
               url: '/user/',
               data: {
                   name: this.student.name,
                   phone: this.student.phone,
                   comment: this.student.comment,
               }
            }).then(response => {
                if(response.status === 200 && response.data > 0){
                    this.$store.dispatch('getStudents');
                }
            });
            this.dialog = false;
        }
    }
}

</script>

<style scoped>

</style>
