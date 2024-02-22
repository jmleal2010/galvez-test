<template>
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">

                            <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[route === item.name ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                        </div>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>

                        <!-- Profile dropdown -->

                    </div>
                </div>

            </div>
        </div>
    </Disclosure>
</template>

<script setup>
import {computed, onMounted, ref} from 'vue'
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import {BellIcon} from "@heroicons/vue/24/outline/index.js";
import {useRoute, useRouter} from "vue-router";

const location = useRouter();
const route = ref('')

onMounted(()=>{
   route.value = location.currentRoute._value.name
})
const navigation = [
    { name: 'Dashboard', href:'/', },
    { name: 'Checklist', href: '/checklist' },
]

const user = {
    name: 'Tom Cook',
    email: 'tom@example.com',
    imageUrl:
        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
}


</script>
