<template>
    <v-row>
        <v-text-field
            class="my-4"
            label="Фильтр"
            v-model="filter"
        ></v-text-field>
    </v-row>
</template>
<script>
export default{
    data(){
        return {
            filter: ''
        }
    },
    watch: {
        filter(newFilterValue, oldFilterValue){
            if(newFilterValue !== oldFilterValue)
                this.$emit('filter', newFilterValue);
        }
    }
}
</script>
