<template>
    <schedule-modal-component ref="scheduleModal"/>
    <v-container>
        <v-row>
            <h1>Расписание</h1>
        </v-row>
        <v-row>
            <vue-cal
                locale="ru"
                :time-from="7 * 60"
                :time-to="22 * 60"
                :selected-date="currentDate"
                v-model:active-view="viewCal"
                class="vuecal--green-theme"
                cell-contextmenu
                :events="$store.getters.getEvents"
                :split-days="$store.getters.getCabinets"
                @event-focus="showDetail($event)"
                @cell-dblclick="createEvent($event)"
                dragToCreateEvent="true"
            />
        </v-row>
    </v-container>
</template>

<script>
import VueCal from 'vue-cal'
import ScheduleModal from "./modal/ScheduleModal.vue";
import 'vue-cal/dist/vuecal.css'
import ScheduleModalComponent from "./modal/ScheduleModal.vue";

export default {
    name: 'ScheduleComponent',
    components: {
        ScheduleModalComponent,
        VueCal,
        ScheduleModal
    },
    data() {
        return {
            viewCal: ''
        }
    },
    mounted() {
        this.$store.dispatch('getEvents');
        this.$store.dispatch('getCabinets');
    },
    computed: {
      currentDate: function (){
          const today = new Date();
          return today.toISOString().split('T')[0];
      }
    },
    methods: {
        createEvent(event){
            if(this.viewCal === 'day'){
                const dateStart = this.dateInputFormat(event.date);
                const cabinet = event.split;

                const data = {
                    key: 'cabinet_id',
                    value: cabinet
                }

                this.$store.dispatch('clearRepeats');
                this.$store.commit('addToNewEvent', data);

                this.$refs.scheduleModal.dialog = true;
                this.$refs.scheduleModal.dateStart = dateStart;
            }
        },
        dateInputFormat(date){
            const yyyy = date.getFullYear();
            const mm = ('0' + (date.getMonth() + 1)).slice(-2);
            const dd = ('0' + date.getDate()).slice(-2);
            const hours = ('0' + date.getHours()).slice(-2);
            const minutes = ('0' + date.getMinutes()).slice(-2);
            return yyyy + '-' + mm + '-' + dd + 'T' + hours + ':' + minutes;
        },
        showDetail(event){
            this.$router.push('/event/' + event.id + '/detail/');
        }
    }
}
</script>

<style>

.vuecal__event.lesson{
    background: #BBDEFB;
    font-size: 11px;
}

</style>
