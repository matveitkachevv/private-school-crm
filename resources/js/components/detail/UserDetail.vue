<template>
    <v-container>
        <v-row
            justify="start"
            align="center">
            <h2 v-if="!edit">{{ user.name }}</h2>
            <div
                v-if="!edit"
                role="button"
                class="mx-4 round-icon">
                <v-icon
                    @click="editUser"
                    icon="mdi-pencil-outline"
                    size="small">
                </v-icon>
            </div>
            <v-col
                v-if="edit"
                cols="3">
                <v-text-field
                    label="ФИО"
                    v-model="editStudent.name"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row
            align="end"
            justify="start"
        >
            <v-col
                cols="2"
                v-if="user.groupId > 0">
                <h3>Группа: {{ user.groupName }}</h3>
                <v-btn
                @click="showGroupDetail(user.groupId)">
                    Открыть группу
                </v-btn>
            </v-col>
            <v-col
                cols="2"
            >
                <subscribe-modal-component
                    @restart="onRestart"
                    :student="user.id"
                />
            </v-col>
            <v-col
                cols="2"
            >
                <change-group
                    :userid="user.id"
                    @update-user="getUserDetailInfo()"
                />
            </v-col>
            <v-col>
                <v-btn
                    @click="deleteUser(user.id)">
                    Удалить пользователя
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col
                v-if="!edit"
                cols="12"
            >
                <h4>Номер телефона:</h4>
                {{ user.phone }}
            </v-col>
            <v-col
                cols="3"
                v-else>
                <v-text-field
                    label="Номер телефона"
                    v-model="editStudent.phone"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col
                v-if="!edit"
                cols="12">
                <h4>Комментарий:</h4>
                {{ user.comment }}
            </v-col>
            <v-col
                cols="3"
                v-else
            >
                <v-text-field
                    label="Комментарий"
                    v-model="editStudent.comment"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row v-if="edit">
            <v-btn
                @click="editSave">
                Сохранить
            </v-btn>
            <v-btn
                class="mx-3"
                @click="editCancel">
                Отменить
            </v-btn>
        </v-row>
        <subscribes-list-component
            :user="user.id"
            ref="subscribeList"
        />
    </v-container>
</template>

<script>
import ChangeGroup from "../modal/ChangeGroup.vue";
import SubscribeModalComponent from "../modal/SubscribeModal.vue";
import SubscribesListComponent from "../lists/SubscribesList.vue";
    export default {
        name: 'UserDetailComponent',
        components: {
            SubscribesListComponent,
            ChangeGroup,
            SubscribeModalComponent
        },
        data() {
            return {
                user: {},
                edit: false,
                editStudent: {
                    name: '',
                    phone: '',
                    comment: ''
                }
            }
        },
        mounted() {
            this.getUserDetailInfo();
        },
        methods: {
            editUser(){
                this.editStudent.name = this.user.name;
                this.editStudent.phone = this.user.phone;
                this.editStudent.comment = this.user.comment;
                this.edit = true;
            },
            editSave(){
                if(this.editStudent.name === ''){
                    this.editCancel();
                    return false;
                }

                axios({
                    method: 'put',
                    url: '/user/' + this.user.id + '/',
                    data: {
                        user: this.editStudent
                    }
                }).then(response => {
                    if(response.status === 200 && response.data > 0){
                        this.getUserDetailInfo();
                        this.edit = false;
                    }
                });
            },
            editCancel(){
                this.editStudent.name = '';
                this.editStudent.phone = '';
                this.editStudent.comment = '';
                this.edit = false;
            },
            onRestart(isRestart){
                if(isRestart){
                    this.$refs.subscribeList.getSubscribes();
                }
            },
            showGroupDetail(groupId){
                this.$router.push('/group/' + groupId + '/');
            },
            getUserDetailInfo(){
                const __this = this;
                axios({
                    method: 'get',
                    url: '/user/' + this.$route.params.id + '/'
                }).then(response => {
                    if(response.status === 200){
                        __this.user = response.data;
                    }
                });
            },
            deleteUser(userId){
                const __this = this;
                axios({
                    method: 'delete',
                    url: '/user/' + userId
                }).then(response => {
                    if(response.status === 200 && response.data > 0){
                        __this.$router.push('/users/');
                    }
                });
            },
        }
    }
</script>
