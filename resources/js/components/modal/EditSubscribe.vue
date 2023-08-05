<template>
        <v-dialog
            v-model="dialog"
        >
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                >
                    Редактировать
                </v-btn>
            </template>
            <v-card max-width="800px">
                <v-card-title>
                    <span class="text-h5">Редактирование абонемента</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-text-field
                                label="Наименование"
                                v-model="subscribe.name"
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Стоимость"
                                v-model="subscribe.price"
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Количество посещений"
                                v-model="subscribe.count"
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <label>Дата окончания абонемента: </label>
                            <input type="date" v-model="subscribe.date_end">
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
                        Сохранить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
</template>

<script>

export default {
    name: 'UserModalComponent',
    props: [
      'subscribeId'
    ],
    data: () => ({
        dialog: false,
        subscribe: {
            name: '',
            price: 0,
            date_end: '',
            count: 0
        }
    }),
    mounted(){
        this.$store.dispatch('getGroups');
        this.getSubscribe();
    },
    computed: {
      subscribeId: function (){
          return this.$props.subscribeId;
      }
    },
    methods: {
        send(){
            axios({
                method: 'put',
                url: '/subscribe/' + this.subscribeId + '/',
                data: {
                    subscribe: this.subscribe
                }
            }).then(response => {
                if(response.status === 200 && response.data > 0){
                    this.$emit('updateSubscribes');
                    this.dialog = false;
                }
            });
        },
        getSubscribe(){
            axios({
                method: 'get',
                url: '/subscribe/' + this.subscribeId + '/'
            }).then(response => {
                if(response.status === 200)
                    this.subscribe = response.data;
            });
        },
    }
}

</script>

<style scoped>

</style>
