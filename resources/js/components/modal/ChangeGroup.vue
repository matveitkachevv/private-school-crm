<template>
        <v-dialog
            v-model="dialog"
        >
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                >
                    Сменить группу
                </v-btn>
            </template>
            <v-card max-width="800px">
                <v-card-title>
                    <span class="text-h5">Сменить группу</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col>
                                <v-autocomplete
                                    :items="groups"
                                    v-model="group"
                                    label="Группа*"
                                    item-title="name"
                                    item-value="id"
                                ></v-autocomplete>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="green-darken-1"
                        variant="text"
                        @click="dialog = false"
                    >
                        Закрыть
                    </v-btn>
                    <v-btn
                        color="green-darken-1"
                        variant="text"
                        @click="send()"
                    >
                        Изменить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
</template>

<script>

export default {
    name: 'UserModalComponent',
    props: [
      'userid'
    ],
    data: () => ({
        dialog: false,
        group: 0
    }),
    mounted(){
        this.$store.dispatch('getGroups');
        this.groups = this.$store.getters.getGroups;
        if(!!this.groups[0])
            this.group = this.groups[0].id;
    },
    computed: {
      userId: function (){
          return this.$props.userid;
      }
    },
    methods: {
        send(){
            const __this = this;
            axios({
               method: 'put',
               url: '/user/' + __this.userId + '/group/change/',
               data: {
                   group_id: this.group
               }
            }).then(response => {
                if(response.status === 200 && response.data > 0){
                    __this.$emit('update-user');
                }
            });
            this.dialog = false;
        }
    }
}

</script>

<style scoped>

</style>
