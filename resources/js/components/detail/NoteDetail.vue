<template>
    <v-container>
        <v-row>
            <h4>Заметка</h4>
        </v-row>
        <v-row>
            Текст: {{ note.text }}
        </v-row>
        <v-row>
            Дата конца: {{ note.date_start }}
        </v-row>
        <v-row>
            Дата начала: {{ note.date_end }}
        </v-row>
        <v-row>
            <v-btn @click="deleteNote">
                Удалить
            </v-btn>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'NoteDetailComponent',
    props: ['id'],
    data(){
        return {
            note: {}
        }
    },
    mounted(){
        axios({
            method: 'get',
            url: '/note/' + this.$route.params.id + '/'
        }).then(response => {
            if(response.status === 200){
                this.note = response.data
            } else{
                const message = 'Что-то пошло не так';
                this.$store.commit('modalMessage', message);
                this.$store.commit('modalShow', true);
            }
        });
    },
    methods: {
        deleteNote(){
            axios({
                method: 'delete',
                url: '/note/' + this.$route.params.id + '/'
            }).then(response => {
                if(response.status === 200){
                    this.$router.push('/notes/');
                } else {
                    const message = 'Что-то пошло не так';
                    this.$store.commit('modalMessage', message);
                    this.$store.commit('modalShow', true);
                }
            });
        }
    }
}
</script>
