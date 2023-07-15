<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
        >
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                >
                    Добавить новый кабинет
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="text-h5">Новый кабинет</span>
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
                                    label="Название кабинета"
                                    v-model="cabinetName"
                                    required
                                ></v-text-field>
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
                        @click="createCabinet()"
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
    name: 'CabinetModalComponent',
    data(){
        return {
            cabinetName: '',
            dialog: false,
        }
    },
    methods: {
        createCabinet(){
            axios({
               method: 'post',
               url: '/cabinet/',
                data: {
                   cabinetName: this.cabinetName
                }
            }).then(response => {
                if(response.status === 200){
                    this.$store.dispatch('getCabinets');
                    this.dialog = false
                }
            });
        }
    }
}
</script>
