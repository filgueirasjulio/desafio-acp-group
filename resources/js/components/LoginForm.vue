<template>
    <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-md rounded-lg">
        <!-- Título -->
        <h1 class="text-xl font-semibold text-gray-800 text-center">Login</h1>

        <!-- Formulário -->
        <form>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="input-field" v-model="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="input-field" v-model="password" required>
            </div>

            <div>
                <button type="button" class="btn-primary w-full mt-4" @click="submitLogin">Login</button>
            </div>
        </form>

        <!-- Link para cadastro -->
        <p class="mt-4 text-sm text-center text-gray-600">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Criar</a>
        </p>
    </div>
</template>

<script>
    import {
        checkTokenAndRedirect
    } from '../app';
    export default {
        data() {
            return {
                email: '',
                password: '',
                errors: {},
                isLoading: false
            };
        },
        methods: {
            async submitLogin() {
                try {
                    const response = await axios.post('/api/login', {
                        email: this.email,
                        password: this.password
                    });

                    const token = response.data.token;
                    localStorage.setItem('authToken', token);

                    // Verifica se o token foi armazenado corretamente
                    const storedToken = localStorage.getItem('authToken');
                    console.log('Token armazenado:', storedToken);

                    if (storedToken) {
                        // Redireciona para o dashboard
                        this.$router.push('/dashboard');
                    }
                } catch (error) {
                    console.error('Erro no login:', error);
                }
            }
        },
        mounted() {
            checkTokenAndRedirect();
        }
    };
</script>
