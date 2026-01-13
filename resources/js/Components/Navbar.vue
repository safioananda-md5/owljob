<script setup>
import { ref } from "vue";
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    Bars3Icon,
    BellIcon,
    CalendarIcon,
    ChartPieIcon,
    Cog6ToothIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";
import { ChevronDownIcon, MagnifyingGlassIcon } from "@heroicons/vue/20/solid";

const userNavigation = [
    { name: "Your profile", href: "#" },
    { name: "Sign out", href: route("login") },
];

const sidebarOpen = ref(false);
</script>

<template>
    <div
        class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-white/10 bg-gray-900 px-4 sm:gap-x-6 sm:px-6 lg:px-8"
    >
        <button
            type="button"
            class="-m-2.5 p-2.5 text-gray-400 hover:text-white lg:hidden"
            @click="sidebarOpen = true"
        >
            <span class="sr-only">Open sidebar</span>
            <Bars3Icon class="size-6" aria-hidden="true" />
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-white/10 lg:hidden" aria-hidden="true" />

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
            <form class="grid flex-1 grid-cols-1" action="#" method="GET">
                <input
                    name="search"
                    aria-label="Search"
                    class="col-start-1 row-start-1 block size-full bg-gray-900 pl-8 text-base text-white outline-hidden placeholder:text-gray-500 sm:text-sm/6"
                    placeholder="Search"
                />
                <MagnifyingGlassIcon
                    class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400"
                    aria-hidden="true"
                />
            </form>
            <div class="flex items-center gap-x-4 lg:gap-x-6">
                <button
                    type="button"
                    class="-m-2.5 p-2.5 text-gray-400 hover:text-white"
                >
                    <span class="sr-only">View notifications</span>
                    <BellIcon class="size-6" aria-hidden="true" />
                </button>

                <!-- Separator -->
                <div
                    class="hidden lg:block lg:h-6 lg:w-px lg:bg-white/10"
                    aria-hidden="true"
                />

                <!-- Profile dropdown -->
                <Menu as="div" class="relative">
                    <MenuButton class="relative flex items-center">
                        <span class="absolute -inset-1.5" />
                        <span class="sr-only">Open user menu</span>
                        <img
                            class="size-8 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10"
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt=""
                        />
                        <span class="hidden lg:flex lg:items-center">
                            <span
                                class="ml-4 text-sm/6 font-semibold text-white"
                                aria-hidden="true"
                                >Tom Cook</span
                            >
                            <ChevronDownIcon
                                class="ml-2 size-5 text-gray-500"
                                aria-hidden="true"
                            />
                        </span>
                    </MenuButton>
                    <transition
                        enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform scale-100"
                        leave-to-class="transform opacity-0 scale-95"
                    >
                        <MenuItems
                            class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-gray-800 py-2 outline-1 -outline-offset-1 outline-white/10"
                        >
                            <MenuItem
                                v-for="item in userNavigation"
                                :key="item.name"
                                v-slot="{ active }"
                            >
                                <a
                                    :href="item.href"
                                    :class="[
                                        active
                                            ? 'bg-white/5 outline-hidden'
                                            : '',
                                        'block px-3 py-1 text-sm/6 text-white',
                                    ]"
                                    >{{ item.name }}</a
                                >
                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
