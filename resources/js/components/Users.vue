<template>
    <v-container>
        <v-row>
            <h1>Ученики</h1>
        </v-row>
        <v-row>
            <v-col cols="3">
                <user-modal/>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <h2>Список учеников:</h2>
                <v-divider class="border-opacity-100 my-4" color="success"></v-divider>
                <v-card>
                    <v-list>
                        <v-list-item
                        v-for="student in $store.getters.getStudents"
                        @click="showUserDetail(student.id)">
                            {{ student.name }}
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import UserModal from "./modal/UserModal.vue";

export default {
    name: 'UsersComponent',
    components: {UserModal},
    mounted(){
        this.$store.dispatch('getStudents');
    },
    methods: {
        showUserDetail(userId){
            this.$router.push('/user/' + userId + '/');
        }
    }
}
</script>

<style scoped>

</style>

