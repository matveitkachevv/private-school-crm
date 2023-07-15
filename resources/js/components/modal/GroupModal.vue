<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
        >
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                >
                    Добавить новую группу
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="text-h5">Новая группа</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                                <v-text-field
                                    label="Название группы*"
                                    v-model="group.name"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                            >
                                <v-autocomplete
                                    :items="$store.getters.getStudents"
                                    v-model="group.students"
                                    label="Ученики"
                                    item-title="name"
                                    item-value="id"
                                    multiple
                                ></v-autocomplete>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*Обязательные поля</small>
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
                        @click="createGroup()"
                    >
                        Добавить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>

export default {
    name: 'GroupModalComponent',
    data: () => ({
        dialog: false,
        group: {
            name: '',
            students: []
        }
    }),
    mounted(){
        this.$store.dispatch('getStudents');
    },
    methods: {
        createGroup(){
            axios({
               method: 'POST',
               url: '/group/',
               data: {
                   groupName: this.group.name,
                   students: this.group.students
               }
            }).then(response => {
                if(response.status === 200 && response.data > 0){
                    this.$store.dispatch('getGroups');
                }
            });
            this.dialog = false
        }
    }
}

</script>

<style scoped>

</style>
