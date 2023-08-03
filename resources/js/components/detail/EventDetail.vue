<template>
    <v-container>
        <v-row>
            <h2>{{ event.name }}</h2>
        </v-row>
        <v-row>
            <v-col>
                <h3>{{ event.groupName }}</h3>
                <v-btn @click="showGroup()">
                    Открыть детальную группы
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-btn @click="deleteEvent()">
                    Удалить запись
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <h3>Время</h3>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                с {{ start }}
                <br>
                до {{ end }}
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <span>Кабинет</span> - {{ event.cabinetName }}
            </v-col>
        </v-row>
        <h3 class="mt-4" v-if="isVisits">Студенты</h3>
        <v-row
            v-if="isVisits"
            class="my-4 mx-4"
            v-for="visit in event.visits">
                <v-checkbox
                    v-model="visit.visited"
                    @click="changeVisited(visit.id)"
                    :label="visit.userName + ' посетил'">
                </v-checkbox>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: 'EventDetailComponent',
        data(){
            return {
                event: {}
            }
        },
        mounted() {
            this.getEventData();
        },
        computed: {
            start: function(){
                return this.dateConvert(this.event.start);
            },
            end: function(){
                return this.dateConvert(this.event.end);
            },
            isVisits: function() {
                return !!this.event.visits && this.event.visits.length > 0;
            }
        },
        methods: {
            getEventData()
            {
                const __this = this;
                axios({
                    method: 'get',
                    url: '/event/' + __this.$route.params.id
                }).then(response => {
                    if(response.status === 200)
                        __this.event = response.data;
                });
            },
            dateConvert(dateString){
                const date = new Date(dateString);

                const yyyy = date.getFullYear();
                const mm = ('0' + (date.getMonth() + 1)).slice(-2);
                const dd = ('0' + date.getDate()).slice(-2);
                const hours = ('0' + date.getHours()).slice(-2);
                const minutes = ('0' + date.getMinutes()).slice(-2);
                return dd + '.' + mm + '.' + yyyy + ' ' + hours + ':' + minutes;
            },
            showGroup(){
                this.$router.push('/group/' + this.event.groupId + '/');
            },
            deleteEvent(){
                const __this = this;
                axios({
                    method: 'delete',
                    url: '/event/' + __this.event.id
                }).then(response => {
                    if(response.status === 200 && response.data > 0){
                        __this.$router.push('/');
                    }
                });
            },
            changeVisited(visitId){
                const __this = this;
                axios({
                    method: 'put',
                    url: '/visit/' + visitId + '/'
                }).then(response => {
                    if(response.status === 200){
                        __this.getEventData();
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
