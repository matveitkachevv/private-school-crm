<template>
    <div class="text-center">
        <v-dialog
            v-model="$store.getters.modalShow"
            width="400"
        >
            <v-card>
                <v-card-text
                    class="text-center white-space">
                    {{ $store.getters.modalMessage }}
                </v-card-text>
                <v-card-actions>
                    <v-btn color="" block @click="$store.commit('modalShow', false)">Закрыть</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    name: 'MessageModalComponent',
    data(){
        return {
            dialog: false,
            message: 'Ошибка'
        }
    },
}
</script>
<style scoped>
.white-space{
    white-space: pre-wrap;
}
</style>
