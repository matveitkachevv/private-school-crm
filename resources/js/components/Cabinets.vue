<template>
    <v-container>
        <v-row>
            <h1>Кабинеты</h1>
        </v-row>
        <v-row>
            <v-col cols="3">
                <cabinet-modal/>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <h2>Список кабинетов:</h2>
                <v-divider class="border-opacity-100 my-4" color="success"></v-divider>
                <v-card>
                    <v-list>
                        <v-list-item
                            v-for="item in $store.getters.getCabinets"
                            @click="deleteCabinet(item.id)">
                            {{ item.label }}
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import CabinetModal from "./modal/CabinetModal.vue";

export default {
    name: 'CabinetsComponent',
    components: {CabinetModal},
    mounted() {
        this.$store.dispatch('getCabinets');
    },
    methods: {
        deleteCabinet(cabinetId){
            const __this = this;
            axios({
                method: 'delete',
                url: '/cabinet/' + cabinetId
            }).then(response => {
                if(response.status === 200 && response.data > 0){
                    __this.$store.dispatch('getCabinets');
                }
            });
        }
    }
}
</script>
