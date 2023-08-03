<template>
    <v-container>
        <v-row
        justify="start"
        align="center">
            <h2 v-if="!edit">{{ group.name }}</h2>
            <v-col
                v-if="edit"
                cols="3">
                <v-text-field
                    label="Название группы*"
                    v-model="editGroupName"
                    required
                ></v-text-field>
            </v-col>
            <div
                v-if="!edit"
                role="button"
                class="mx-4 round-icon">
                <v-icon
                    @click="editGroup"
                    icon="mdi-pencil-outline"
                    size="small">
                </v-icon>
            </div>
            <v-col v-if="edit">
                <v-btn
                @click="editSave">
                    Сохранить
                </v-btn>
                <v-btn
                class="mx-3"
                @click="editCancel">
                    Отменить
                </v-btn>
            </v-col>
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
               group: {},
                edit: false,
                editGroupName: '',
            }
        },
        mounted(){
            this.getGroupData();
        },
        methods: {
            editSave(){
                const __this = this;
                if(this.editGroupName === this.group.name || this.editGroupName === ''){
                    this.editCancel();
                    return false;
                }
                axios({
                   method: 'put',
                   url: '/group/' + this.$route.params.id + '/',
                   data: {
                       groupName: this.editGroupName
                   }
                }).then(response => {
                    if(response.status === 200 && response.data > 0){
                        __this.getGroupData();
                        __this.edit = false;
                    }
                });
            },
            editGroup(){
                this.editGroupName = this.group.name;
                this.edit = true;
            },
            editCancel(){
                this.editGroupName = '';
                this.edit = false;
            },
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
            },
            getGroupData(){
                const __this = this;
                axios({
                    method: 'get',
                    url: '/group/' + __this.$route.params.id + '/'
                }).then(response => {
                    if(response.status === 200){
                        __this.group = response.data;
                    }
                });
            }
        }
    }
</script>
