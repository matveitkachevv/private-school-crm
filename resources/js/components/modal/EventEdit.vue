<template>
    <v-dialog
        v-model="dialog"
    >
        <template v-slot:activator="{ props }">
            <v-btn
                v-bind="props"
            >
                Редактировать занятие
            </v-btn>
        </template>
        <v-card>
            <v-card-title>
                <span class="text-h5">Редактировать занятие</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col>
                            <div>Дата начала</div>
                            <input type="datetime-local" v-model="event.start">
                        </v-col>
                        <v-col>
                            <div>Дата окончания</div>
                            <input type="datetime-local" :min="event.start" v-model="event.end">
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-autocomplete
                                :items="$store.getters.getCabinets"
                                v-model="event.cabinetId"
                                label="Кабинет"
                                item-title="label"
                                item-value="id"
                            ></v-autocomplete>
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
                    @click="save()"
                >
                    Сохранить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default{
    name: 'EventEditModalComponent',
    props: ['eventId'],
    data(){
        return {
            dialog: false,
            cabinets: [],
            event: {
                start: '',
                end: '',
                cabinetId: null,
            },
        }
    },
    mounted(){
      this.$store.dispatch('getCabinets');
    },
    methods: {
        save(){
            if(new Date(this.event.start).getTime() >= new Date(this.event.end).getTime()){
                const message = 'Дата начала не может быть позже даты окончания занятия';
                this.$store.commit('modalMessage', message);
                this.$store.commit('modalShow', true);
                return false;
            }

            if(this.event.start === '' || this.event.end === ''){
                const message = 'Не указаны даты занятия';
                this.$store.commit('modalMessage', message);
                this.$store.commit('modalShow', true);
                return false;
            }

            if(this.event.cabinetId === null || this.event.cabinetId <= 0){
                const message = 'Не выбран кабинет';
                this.$store.commit('modalMessage', message);
                this.$store.commit('modalShow', true);
                return false;
            }

            axios({
                method: 'put',
                url: '/event/' + this.$props.eventId + '/',
                data: {
                    cabinetId: this.event.cabinetId,
                    dateStart: this.event.start,
                    dateEnd: this.event.end,
                }
            }).then(response => {
                if(response.status === 200 && response.data > 0){
                    this.$emit('updateEvent');
                    this.$store.dispatch('getEvents');
                    this.dialog = false;
                }
            }).catch(error => {
                if(error.response.data.error){
                    this.$store.commit('modalMessage', error.response.data.message);
                    this.$store.commit('modalShow', true);
                }
            });
        },
        getEvent(eventId){
            axios({
                method: 'get',
                url: '/event/' + eventId
            }).then(response => {
                console.log(response);
                if(response.status === 200){
                    this.event = response.data;
                } else {
                    const message = 'Занятие не найдено';
                    this.$store.commit('modalMessage', message);
                    this.$store.commit('modalShow', true);
                }
            });
        }
    },
    watch: {
        eventId(eventId){
            if(eventId > 0)
                this.getEvent(this.$props.eventId);
        }
    }
}
</script>
