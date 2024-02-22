<template>
    <div class="min-h-full">

        <Header />
        <router-view></router-view>
        <footer></footer>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import Header from "./common/Header.vue";


</script>
