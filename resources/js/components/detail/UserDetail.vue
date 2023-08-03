<template>
    <v-container>
        <v-row>
            <h2>{{ user.name }}</h2>
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
                cols="12">
                <h4>Номер телефона:</h4>
                {{ user.phone }}
            </v-col>
        </v-row>
        <v-row>
            <v-col
                cols="12">
                <h4>Комментарий:</h4>
                {{ user.comment }}
            </v-col>
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
                user: {}
            }
        },
        mounted() {
            this.getUserDetailInfo();
        },
        methods: {
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
