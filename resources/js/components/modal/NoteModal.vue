<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            width="800"
        >
            <v-card>
                <v-container>
                    <v-card-title>
                        <span class="text-h5">Создать новую заметку</span>
                    </v-card-title>
                    <v-row>
                        <v-col
                            cols="12"
                        >
                            <v-text-field v-model="text" label="Текст"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="6"
                        >
                            Дата начала заметки
                            <v-spacer></v-spacer>
                            <input type="datetime-local" v-model="dateStart">
                        </v-col>
                        <v-col
                            cols="6"
                        >
                            Дата окончания заметки
                            <v-spacer></v-spacer>
                            <input type="datetime-local" v-model="dateEnd">
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

export default {
    name: 'NoteModalComponent',
    data () {
        return {
            dialog: false,
            dateStart: '',
            dateEnd: '',
            text: '',
        }
    },
    mounted(){
    },
    methods: {
        createEvent(){
            const dateStart = this.getDateFormat(new Date(this.dateStart));
            const dateEnd = this.getDateFormat(new Date(this.dateEnd));
            const text = this.text;

            axios({
                method: 'post',
                url: '/note/',
                data: {
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                    noteText: text
                }
            }).then(response => {
                if(response.status === 200){
                    this.dialog = false;
                    this.dateStart = '';
                    this.dateEnd = '';
                    this.text = '';
                    this.$store.dispatch('getNotes');
                }
            });

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
