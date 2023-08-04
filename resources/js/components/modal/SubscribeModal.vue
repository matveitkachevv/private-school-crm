<template>
        <v-dialog
            v-model="dialog"
        >
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                >
                    Новый абонемент
                </v-btn>
            </template>
            <v-card max-width="800px">
                <v-card-title>
                    <span class="text-h5">Новый абонемент</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    label="Название абонемента"
                                    v-model="subscribe.name"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    label="Цена абонемента"
                                    v-model="subscribe.cost"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    label="Количество посещений"
                                    v-model="subscribe.count"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <v-autocomplete
                                    :items="$store.getters.getGroups"
                                    v-model="subscribe.group_id"
                                    label="Группа"
                                    item-title="name"
                                    item-value="id"
                                ></v-autocomplete>
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <label>Окончание действия абонемента</label>
                                <br>
                                <input type="date" v-model="subscribe.dateEnd">
                            </v-col>
                        </v-row>
                    </v-container>
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
</template>

<script>
export default {
    name: 'SubscribeModalComponent',
    props: [
        'student',
        'restart'
    ],
    data: () => ({
        dialog: false,
        subscribe: {
            name: '',
            cost: 0,
            count: 4,
            dateEnd: '',
            group_id: null,
        }
    }),
    mounted(){
        this.$store.dispatch('getGroups');
    },
    methods: {
        send(){
            const __this = this;
            axios({
               method: 'post',
                url: '/subscribe/',
                data: {
                    studentId: __this.student,
                    subscribe: __this.subscribe
                }
            }).then(response => {
                if(response.status === 200){
                    __this.$emit('restart', true);
                    __this.dialog = false;
                }
            });
        }
    }
}
</script>
