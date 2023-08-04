<template>
    <v-container v-if="subscribes.length > 0">
        <v-row>
            <h4>Абонементы</h4>
        </v-row>
        <v-row
            class="py-4 my-4"
            v-for="subscribe in subscribes"
        >
            <v-col
                class="my-2"
                cols="12"
            >
                <v-row
                    justify="start"
                    align="center"
                >
                    <v-btn
                    @click="deleteSubscribe(subscribe.id)"
                    >
                        Удалить
                    </v-btn>
                    <v-btn
                        class="mx-3"
                        @click="editSubscribe(subscribe.id)"
                    >
                        редактировать
                    </v-btn>
                </v-row>
            </v-col>
            <v-col
                class="subscribe-row-data py-0"
                cols="12"
            >
                Наименование: <b>{{ subscribe.name }}</b>
            </v-col>
            <v-col
                class="subscribe-row-data py-0"
                cols="12"
            >
                Группа: <b>{{ subscribe.groupName }}</b>
            </v-col>
            <v-col
                class="subscribe-row-data py-0"
                cols="12"
            >
                Сумма: <b>{{ subscribe.price }} руб.</b>
            </v-col>
            <v-col
                class="subscribe-row-data py-0"
                cols="12"
            >
                Действует до: <b>{{ convertToDdMmYyyy(subscribe.date_end) }}</b>
            </v-col>
            <v-col
                class="subscribe-row-data py-0"
                cols="12"
            >
                Количество посещений: <b>{{ subscribe.count }}</b>
            </v-col>
            <v-col
                class="subscribe-row-data py-0"
                cols="12"
            >
                Осталось посещений: <b>{{ (Number(subscribe.count) - (subscribe.visit_count)) }}</b>
            </v-col>
            <v-col
                cols="12"
                v-if="subscribe.visits.length > 0"
            >
                <h3>Посещения</h3>
                <v-row v-for="visit in subscribe.visits">
                    <v-col>
                        Дата занятия: {{ convertToDdMmYyyy(visit.date_visit) }}
                    </v-col>
                    <v-col>
                        Посетил занятие: <b>{{ visit.visited ? 'Посетил' : 'Не посетил' }}</b>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'SubscribesListComponent',
    props: ['user'],
    data(){
        return {
            subscribes: []
        }
    },
    watch: {
        user(){
            this.getSubscribes();
        }
    },
    methods:{
        getSubscribes(){
            const __this = this;
            axios({
                method: 'get',
                url: '/user/' + __this.user + '/subscribes/'
            }).then(response => {
                if(response.status === 200){
                    __this.subscribes = response.data;
                }
            });
        },
        deleteSubscribe(subscribeId){
            const __this = this;
            axios({
                method: 'delete',
                url: '/subscribe/' + subscribeId
            }).then(response => {
                if(response.status === 200 && response.data > 0){
                    __this.getSubscribes();
                }
            });
        },
        editSubscribe(subscribeId){
            console.log(subscribeId);
        },
        pay(subscribeId){
            const __this = this;
            axios({
                method: 'put',
                url: '/subscribe/' + subscribeId + '/payment/'
            }).then(response => {
                if(response.status === 200){
                    __this.getSubscribes();
                }
            });
        },
        convertToDdMmYyyy(date){
            const dateObject = new Date(date);

            const year = dateObject.getFullYear();
            const month = ('0'+(Number(dateObject.getMonth()) + 1)).slice(-2);
            const day = ('0'+(Number(dateObject.getDate()))).slice(-2);

            return day + '.' + month + '.' + year;
        },
    }
}
</script>
