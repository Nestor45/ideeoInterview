<template>
    <v-toolbar density="compact">
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>Title</v-toolbar-title>

        <v-spacer></v-spacer>
        <v-row>
            <v-col><router-link to="/">Home</router-link></v-col>
            <v-col><router-link to="/contactos">Contactos</router-link></v-col>
            <v-col><router-link to="/login">Login</router-link></v-col>
            <v-col><router-link to="/register">Register</router-link></v-col>
            <v-col><v-btn @click="logout()" >Logout</v-btn></v-col>
        </v-row>
    </v-toolbar>
  </template> 


<script>
import { useRouter } from 'vue-router';
export default {
    setup() {
        const router = useRouter();
        function logout() {
            localStorage.removeItem('token');
            router.push({name:'Login'})
        }
        return {
            logout
        }
    }
}
</script>