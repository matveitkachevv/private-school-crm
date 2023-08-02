<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            width="800"
        >
            <v-card>
                <v-container>
                    <v-card-title>
                        <span class="text-h5">Создать новое занятие</span>
                    </v-card-title>
                    <v-row>
                        <v-col
                        v-if="error.length > 0"
                        cols="12">
                            <ErrorMessage :message="error"/>
                        </v-col>
                        <v-col>
                            <v-autocomplete
                                :items="$store.getters.getGroups"
                                v-model="group_id"
                                label="Группа"
                                item-title="name"
                                item-value="id"
                            ></v-autocomplete>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="6"
                        >
                            Дата начала занятия
                            <v-spacer></v-spacer>
                            <input type="datetime-local" v-model="dateStart">
                        </v-col>
                        <v-col
                            cols="6"
                        >
                            Дата окончания занятия
                            <v-spacer></v-spacer>
                            <input type="datetime-local" :min="dateStart" v-model="dateEnd">
                        </v-col>
                    </v-row>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="green-darken-1"
                        variant="text"
                        @click="closeModal()"
                    >
                        Закрыть
                    </v-btn>
                    <v-btn
                        color="green-darken-1"
                        variant="text"
                        @click="createEvent()"
                    >
                        Создать
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
import ErrorMessage from './Error.vue';
export default {
    name: 'ScheduleModalComponent',
    components: {
        ErrorMessage
    },
    data () {
        return {
            dialog: false,
            group_id: 0,
            duration: 2000,
            dateStart: '',
            dateEnd: '',
            error: '',
        }
    },
    mounted(){
        this.$store.dispatch('getGroups');
    },
    watch: {
        error(newError){
            const timer = setTimeout(() => {
                this.error = '';
            }, this.duration);
            if(newError === '' && !!timer)
                clearTimeout(timer);
        }
    },
    methods: {
        createEvent(){
            if(new Date(this.dateStart).getTime() >= new Date(this.dateEnd).getTime()){
                this.error = 'Дата начала не может быть позже даты окончания занятия';
                return false;
            }

            if(this.group_id <= 0){
                this.error = 'Не выбрана группа';
                return false;
            }

            if(this.dateStart.length <= 0){
                this.error = 'На назначена дата начала занятия';
                return false;
            }

            if(this.dateEnd.length <= 0){
                this.error = 'На назначена дата окончания занятия';
                return false;
            }

            const groupData = {
                key: 'group_id',
                value: this.group_id
            }
            this.$store.commit('addToNewEvent', groupData);

            const nameData = {
                key: 'name',
                value: 'Занятие'
            }
            this.$store.commit('addToNewEvent', nameData);

            const classData = {
                key: 'class',
                value: 'lesson'
            }
            this.$store.commit('addToNewEvent', classData);

            const dateStart = this.getDateFormat(new Date(this.dateStart));
            const dateEnd = this.getDateFormat(new Date(this.dateEnd));

            const dates = {
                start: dateStart,
                end: dateEnd
            }
            this.$store.commit('addToNewEventDateRepeat', dates);
            this.$store.dispatch('createEvent');
            this.closeModal();
            this.$store.dispatch('getEvents');
        },
        getDateFormat(date){
            const yyyy = date.getFullYear();
            const mm = ('0' + (date.getMonth() + 1)).slice(-2);
            const dd = ('0' + date.getDate()).slice(-2);
            const hours = ('0' + date.getHours()).slice(-2);
            const minutes = ('0' + date.getMinutes()).slice(-2);
            return dd + '.' + mm + '.' + yyyy + ' ' + hours + ':' + minutes;
        },
        closeModal(){
            this.$store.dispatch('clearNewEvent');
            this.group_id = 0;
            this.dateStart = '';
            this.dateEnd = '';
            this.dialog = false;
        }
    }
}
</script>

<style scoped>

</style>
