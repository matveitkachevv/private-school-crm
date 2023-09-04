<template>
    <v-dialog
        v-model="dialog"
    >
        <template v-slot:activator="{ props }">
            <v-btn
                v-bind="props"
            >
                Редактировать учеников группы
            </v-btn>
        </template>
        <v-card>
            <v-card-title>
                <span class="text-h5">Редактировать учеников группы</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col
                            cols="12"
                            sm="6"
                        >
                            <v-autocomplete
                                :items="items"
                                v-model="students"
                                label="Ученики"
                                item-title="name"
                                item-value="id"
                                multiple
                                cache-items
                                hide-no-data
                                hide-details
                                v-model:search="search"
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
                    @click="saveGroup()"
                >
                    Сохранить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'CabinetModalComponent',
    props: ['groupId'],
    data(){
        return {
            items: [],
            students: [],
            search: null,
            dialog: false,
        }
    },
    mounted(){
        this.getStudentsGroup();
        this.$store.dispatch('getStudents');
    },
    watch: {
        search(val){
            this.querySelections(val);
        }
    },
    methods: {
        querySelections (v) {
            this.items = this.$store.getters.getStudents.filter(e => {
                return (e.name || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
            }).slice(0, 3);
        },
        saveGroup(){
            axios({
                method: 'post',
                url: '/group/' + this.$props.groupId + '/students/',
                data: {
                    students: this.students
                }
            }).then(response => {
                if(response.status === 200 && response.data > 0){
                    this.$emit('changed');
                    this.dialog = false;
                }
            });
        },
        getStudentsGroup(){
            axios({
                method: 'get',
                url: '/group/' + this.$props.groupId + '/students/'
            }).then(response => {
                if(response.status === 200){
                    this.students = response.data;
                }
            });
        }
    }
}
</script>
