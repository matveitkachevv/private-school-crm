<template>
    <note-modal-component ref="noteModal"/>
    <v-container>
        <v-row>
            <h1>Заметки</h1>
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
                :events="$store.getters.getNotes"
                @event-focus="showDetail($event)"
                @cell-dblclick="createEvent($event)"
                dragToCreateEvent="true"
            />
        </v-row>
    </v-container>
</template>

<script>
import VueCal from "vue-cal";
import NoteModalComponent from "./modal/NoteModal.vue";

export default {
    name: 'NotesComponent',
    components: {
        NoteModalComponent,
        VueCal
    },
    data() {
        return {
            viewCal: 'day'
        }
    },
    mounted(){
      this.$store.dispatch('getNotes');
    },
    computed: {
        currentDate: function (){
            const today = new Date();
            return today.toISOString().split('T')[0];
        }
    },
    methods: {
        showDetail(note){
            this.$router.push('/note/' + note.id + '/');
        },
        createEvent(noteData){
            this.$refs.noteModal.dialog = true;
            this.$refs.noteModal.dateStart = this.dateInputFormat(noteData);
        },
        dateInputFormat(date){
            const yyyy = date.getFullYear();
            const mm = ('0' + (date.getMonth() + 1)).slice(-2);
            const dd = ('0' + date.getDate()).slice(-2);
            const hours = ('0' + date.getHours()).slice(-2);
            const minutes = ('0' + date.getMinutes()).slice(-2);
            return yyyy + '-' + mm + '-' + dd + 'T' + hours + ':' + minutes;
        },
    }
}
</script>
