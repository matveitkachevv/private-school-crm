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
        <Filter
            @filter="filterGroups"
            ref="filter"
        />
        <v-row>
            <v-col>
                <h2>Список групп:</h2>
                <v-divider class="border-opacity-100 my-4" color="success"></v-divider>
                <v-card>
                    <v-list>
                        <v-list-item
                        v-for="item in groups"
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
import Filter from './Filter.vue';

export default {
    name: 'GroupsComponent',
    components: {
        GroupModal,
        Filter
    },
    data(){
        return {
           groups: [],
        }
    },
    mounted() {
        this.$store.dispatch('getGroups');
        this.groups = this.$store.getters.getGroups;
    },
    methods: {
        showDetailGroup(groupId){
            this.$router.push('/group/' + groupId + '/');
        },
        filterGroups(filterString){
            if(filterString === '')
                this.groups = this.$store.getters.getGroups;
            else {
                this.groups = this.groups.filter(value => {
                    return value.name.toLowerCase().indexOf(filterString.toLowerCase()) >= 0;
                });
            }
        }
    },
    watch: {
        storeGroups(groups) {
            this.groups = groups;
            this.$refs.filter.filter = '';
        }
    },
    computed: {
        storeGroups: function(){
            return this.$store.state.groups;
        }
    }
}
</script>

<style scoped>

</style>
