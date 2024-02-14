<template>
  <div class="container">
      <v-sheet  class="bg-deep-purple pa-12" rounded>
        <v-card class="mx-auto px-6 py-8" max-width="344">
          <v-form
            @submit.prevent="login"
          >
            <v-text-field
              v-model="form.email"
              :readonly="loading"
              :rules="emailRules"
              class="mb-2"
              clearable
              type="email"
              label="Correo"
            ></v-text-field>

            <v-text-field
              type="password"
              v-model="form.password"
              :readonly="loading"
              :rules="[required]"
              clearable
              label="Contraseña"
              placeholder="Introduce la contraseña"
            ></v-text-field>

            <br>

            <v-btn
              :disabled="!form"
              :loading="loading"
              block
              color="success"
              size="large"
              type="submit"
              variant="elevated"
            >
              Sign In
            </v-btn>
          </v-form>
        </v-card>
      </v-sheet>
    </div>
</template>
    

<script>
import axios from 'axios';
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
export default {
  setup() {
    let form = reactive({
      email: null,
      password: null,
    });
    const router = useRouter();
    let error = ref('')

    const login = async() => {
      await axios.post('/api/login', form).then(res => {
        console.log(res)
        if (res.data.success) {
          localStorage.setItem('token', res.data.data.token);
          router.push({name:'Home'})
        } else {
          error.value = res.data.message;
        }
      })
    }
    return {
      form,
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
      login,
      error,
    }
  },
  data: () => ({
    form: false,
    loading: false,
  }),

  methods: {
    onSubmit () {
      const formObjetoPlano = JSON.parse(JSON.stringify(this.form));
      console.log(formObjetoPlano);
      if (!this.form) return

      this.loading = true

      setTimeout(() => (this.loading = false), 2000)
    },
    required (v) {
      return !!v || 'Field is required'
    },
  },
}
</script>