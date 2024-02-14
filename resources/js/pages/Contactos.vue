<template>
    <div>
        <v-card max-width="1200" class="mx-auto">
            <v-card-title class="text-center">Contactos</v-card-title>
            <div class="d-flex justify-end">
                <v-btn elevation="8" @click="agregarContacto()">Agregar nuevo Contacto</v-btn>
            </div>
            <div class="text-center">
                <v-table>
                    <thead>
                        <tr>
                            <th class="text-center"><h4>Nombre</h4></th>
                            <th class="text-center"><h4>Correo</h4></th>
                            <th class="text-center"><h4>Mensaje</h4></th>
                            <th class="text-center"><h4>Latitud</h4></th>
                            <th class="text-center"><h4>Longitud</h4></th>
                            <th class="text-center"><h4>Acciones</h4></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in contactos" :key="item.contacto_id">
                            <td>{{ item.full_name }}</td>
                            <td>{{ item.email  }}</td>
                            <td>{{ item.message }}</td>
                            <td>{{ item.localtion_lati }}</td>
                            <td>{{ item.localtion_lagi }}</td>
                            <td>
                                <v-row>
                                    <v-col><v-btn @click="editarContacto(item)">editar</v-btn></v-col>
                                    <v-col><v-btn @click="eliminarContacto(item)">eliminar</v-btn></v-col>
                                </v-row>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </div>
        </v-card>
        <v-dialog v-model="agregarContactoF" max-width="50rem">
            <v-card>
                <v-container>
                    <v-card-title>{{title}} Contacto </v-card-title>
                    <v-form>
                        <v-text-field v-model="contacto.full_name" :rules="fullNameRules" label="Nombre" ></v-text-field>
                        <v-text-field v-model="contacto.email" :rules="emailRules" label="Correo" ></v-text-field>
                        <v-textarea v-model="contacto.message" label="Mensaje" ></v-textarea>
                        <v-text-field v-model="contacto.localtion_lati" label="Latitud" ></v-text-field>
                        <v-text-field v-model="contacto.localtion_lagi" label="Longitud" ></v-text-field>
                        <div v-if="title == 'Editar'">
                            <v-btn @click="guardarContacto()" block class="mt-2" color="primary">Editar Contacto</v-btn>
                        </div>
                        <div v-else>
                            <v-btn @click="guardarContacto()" block class="mt-2" color="primary">Agregar Contacto</v-btn>
                        </div>
                    </v-form>
                </v-container>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            agregarContactoF: false,
            title: '',
            contacto: {
                full_name: '',
                email: "",
                message: "",
                localtion_lati: "",
                localtion_lagi: ""
            },
            fullNameRules: [value => {
                if (value?.length > 2) return true
                    return 'Necesita ingresar un nombre';
            }],
            emailRules: [value => {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value) {
                    return 'Ingrese un correo electrónico';
                }
                if (!emailRegex.test(value)) {
                    return 'Ingrese un correo electrónico válido';
                }
                return true;
            }],
        }
    },
    created() {
        this.getContactos();
    },
    computed: {
        contactos() {
            return this.$store.getters.getContactos;
        }
    },
    methods: {
        async getContactos() {
            try {
                let response = await axios.get('/api/contactos');
                if (response.status === 200) {
                    if (response.data.status === 'ok') {
                        this.$store.commit('setContactos', response.data.contactos);
                    } else {
                        alert('Ocurrió un error al obtener los contactos');
                    }
                } else {
                    alert('Ocurrió un error al obtener los contactos');
                }
            } catch (error) {
                alert('Ocurrió un error al obtener los contactos'+ error);
            }
        },
        agregarContacto() {
            this.title = 'Agregar';
            this.agregarContactoF = true;
        },
        cerrarModal() {
            this.agregarContactoF = false
            this.contacto.full_name = ''
            this.contacto.email = ''
            this.contacto.message = ''
            this.contacto.localtion_lagi = ''
            this.contacto.localtion_lati = ''
        },
        async guardarContacto() {
            const contactoObjetoPlano = JSON.parse(JSON.stringify(this.contacto));
            if (this.title === 'Editar') {
                console.log(this.contacto);
                console.log(contactoObjetoPlano);
                let response = await axios.put('/api/editar-contacto', contactoObjetoPlano)
                if (response.status === 200) {
                    if (response.data.status === 'ok') {
                        this.getContactos()
                        this.cerrarModal();
                    } else {
                        alert('Ocurrió un error al editar el contacto')
                    }
                } else if (response.status === 400) {
                    this.cerrarModal();
                    alert('El contacto ya existe')
                }
            } else {
                console.log("Crear contacto");
                let response = await axios.post('/api/registrar-contacto', contactoObjetoPlano)
                if (response.status === 201) {
                    if (response.data.status === 'ok') {
                        this.$store.commit('setContactos', response.data.contacto)
                        this.getContactos()
                        this.cerrarModal();
                    } else {
                        alert('Ocurrió un error al crear el contacto')
                    }
                }
            }
        },
        editarContacto(item) {
            console.log(item.contacto_id);
            this.title = 'Editar'
            this.contacto.contacto_id = item.contacto_id
            this.contacto.full_name = item.full_name
            this.contacto.email = item.email
            this.contacto.message = item.message
            this.contacto.localtion_lati = item.localtion_lati
            this.contacto.localtion_lagi = item.localtion_lagi
            this.agregarContactoF = true
        },
        async eliminarContacto(item){
            let contactoEliminado = {}
            console.log(item.contacto_id);
            contactoEliminado.contacto_id = item.contacto_id
            console.log(contactoEliminado);
            try {
                let response = await axios.post('/api/eliminar-contacto', contactoEliminado)
                if (response.status === 200) {
                    alert('contacto eliminado con exito')
                    this.getContactos()
                }
            } catch (error) {
                alert('Ocurrio un error al eliminar el Contacto')
            }
        }
    }
}
</script>