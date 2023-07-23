<template>
    <v-app>
        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"
                icon="mdi:mdi mdi-menu"
            >
            </v-app-bar-nav-icon>
            <v-toolbar-title>Лингвария</v-toolbar-title>
        </v-app-bar>
        <v-navigation-drawer
            v-model="drawer"
        >
            <v-list>
                <v-list-item
                    v-for="[icon, text, link] in links"
                    :key="icon"
                    :to="link"
                >
                    <template v-slot:prepend>
                        <v-icon>{{ icon }}</v-icon>
                    </template>
                    <v-list-item-title>{{ text }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-main class="bg-indigo-lighten-5">
            <v-container>
                <v-row>
                    <router-view></router-view>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    data: () => ({
        drawer: false,
        links: [],
    }),
    mounted(){
        this.links = this.$store.getters.getLinks;
    }
}
</script>

<style>
.vuecal {
    margin: auto;
    max-width: 1300px;
    max-height: 662px;
}

.vuecal__event {
    background-color: rgba(173, 216, 230, 0.5);
    box-sizing: border-box;
    padding: 5px;
}
.vuecal__event.lunch {
    background: repeating-linear-gradient(45deg, transparent, transparent 10px, #f2f2f2 10px, #f2f2f2 20px);
}

.vuecal__header{
    font-size: 12px;
}

.vuecal__event.group{
    background: #283593;
    color: #fff;
}

.vuecal__event.note{
    background: #FBC02D;
    color: #000;
}

.split-label, .vuecal__no-event{
    font-size: 10px;
}
</style>
