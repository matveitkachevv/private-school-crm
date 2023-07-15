<template>
    <v-container>
        <v-row>
            <h2>{{ group.name }}</h2>
        </v-row>
        <v-row>
            <v-col cols="6">
                <v-btn
                    @click="deleteGroup(group.id)">
                    Удалить группу
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col
            cols="12">
                <h3>Ученики:</h3>
            </v-col>
            <v-col
            cols="12">
                <v-list>
                    <v-list-item
                    v-for="student in group.students"
                    @click="showStudentDetail(student.id)">
                        {{ student.name }}
                    </v-list-item>
                </v-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: 'GroupDetailComponent',
        data() {
            return {
               group: {}
            }
        },
        mounted(){
            const __this = this;
            axios({
                method: 'get',
                url: '/group/' + __this.$route.params.id + '/'
            }).then(response => {
                if(response.status === 200){
                    __this.group = response.data;
                }
            });
        },
        methods: {
            showStudentDetail(studentId){
                this.$router.push('/user/' + studentId + '/');
            },
            deleteGroup(groupId){
                const __this = this;
                axios({
                    method: 'delete',
                    url: '/group/' + groupId
                }).then(response => {
                    if(response.status === 200 && response.data > 0){
                        __this.$router.push('/groups/');
                    }
                });
            }
        }
    }
</script>
