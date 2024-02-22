<script setup>

import Header from "./Header.vue";
import Calendar from "./Calendar.vue";
</script>

<template>
    <header class="bg-white shadow">
        <div class=" max-w-lg px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Checklist</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto py-6 sm:px-6 lg:px-8">
            <Calendar />
        </div>
    </main>
</template>

<style scoped>

</style>
