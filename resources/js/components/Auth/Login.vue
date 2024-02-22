<script setup>
import router from '../../router.js';
import {ref} from 'vue';

const email = ref('');
const password = ref('');

const login = async () => {
    if (!email.value || !password.value) {
        alert('Por favor ingresa tu email y contraseña');
        return;
    }


    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value)) {
        alert('Por favor ingresa un email válido');
        return;
    }

    try {

        const response = {ok: true, json: () => Promise.resolve({accessToken: 'dummyAccessToken'})};

        if (response.ok) {
            const data = await response.json();

            router.push('/private-route');
        } else {
            alert('Credenciales inválidas. Por favor, intenta de nuevo.');
        }
    } catch (error) {
        console.error('Error al iniciar sesión:', error);
        alert('Ocurrió un error al iniciar sesión. Por favor, intenta de nuevo más tarde.');
    }
};
</script>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img alt="Your Company" class="mx-auto h-10 w-auto"
                 src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"/>
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Accede a tu cuenta</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="#" class="space-y-6" method="POST">
                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-900" for="email">Email</label>
                    <div class="mt-2">
                        <input id="email"
                               v-model="email" autocomplete="email"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 outline-0 px-2"
                               name="email" required=""
                               type="email"/>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                               for="password">Contraseña</label>

                    </div>
                    <div class="mt-2">
                        <input id="password" v-model="password" autocomplete="current-password"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 outline-0 px-2"
                               name="password" required=""
                               type="password"/>
                    </div>
                </div>

                <div>
                    <button
                        @click="login"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        type="submit">
                        Iniciar sesión
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                No eres miembro aún?
                {{ ' ' }}
                <a class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500" href="#">Regístrate</a>
            </p>
        </div>
    </div>
</template>

<style scoped>

</style>
