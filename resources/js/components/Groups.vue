<template>
    <v-container>
        <v-row>
            <h1>Группы</h1>
        </v-row>
        <v-row>
           <v-col cols="3">
               <group-modal/>
           </v-col>
        </v-row>
        <v-row>
            <v-col>
                <h2>Список групп:</h2>
                <v-divider class="border-opacity-100 my-4" color="success"></v-divider>
                <v-card>
                    <v-list>
                        <v-list-item
                        v-for="item in $store.getters.getGroups"
                        @click="showDetailGroup(item.id)">
                            {{ item.name }}
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import GroupModal from "./modal/GroupModal.vue";

export default {
    name: 'GroupsComponent',
    components: {GroupModal},
    mounted() {
        this.$store.dispatch('getGroups');
    },
    methods: {
        showDetailGroup(groupId){
            this.$router.push('/group/' + groupId + '/');
        }
    }
}
</script>

<style scoped>

</style>
