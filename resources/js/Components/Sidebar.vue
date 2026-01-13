<script setup>
import { ref, computed } from "vue";
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
    BriefcaseIcon,
    CalendarIcon,
    ChartPieIcon,
    Cog6ToothIcon,
    DocumentDuplicateIcon,
    HomeIcon,
    XMarkIcon,
    BanknotesIcon,
    CreditCardIcon,
    BuildingStorefrontIcon,
} from "@heroicons/vue/24/outline";
import { ChevronRightIcon, MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import Navbar from "./Navbar.vue";
import { usePage } from "@inertiajs/vue3";
const page = usePage();
const currentRoute = computed(() => page.props.currentRouteName);
var routeName = currentRoute.value;

const dashboard_menu = {
    name: "Dashboard",
    icon: HomeIcon,
    current: false,
};

const navigation = computed(() => [
    {
        name: "Expenses (Pengeluaran)",
        href: route("admin.expenses.index"),
        RName: "admin.expenses.index",
        icon: BanknotesIcon,
        current: false,
    },
    {
        name: "Dept (Hutang)",
        href: route("admin.debt.index"),
        RName: "admin.debt.index",
        icon: CreditCardIcon,
        current: false,
    },
    {
        name: "Wishlist",
        href: "javascript:void(0)",
        RName: "#",
        icon: BuildingStorefrontIcon,
        current: false,
    },
]);

const sidebarOpen = ref(false);
</script>

<template>
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog
                class="relative z-50 lg:hidden"
                @close="sidebarOpen = false"
            >
                <TransitionChild
                    as="template"
                    enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0"
                    enter-to=""
                    leave="transition-opacity ease-linear duration-300"
                    leave-from=""
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild
                        as="template"
                        enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full"
                        enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform"
                        leave-from="translate-x-0"
                        leave-to="-translate-x-full"
                    >
                        <DialogPanel
                            class="relative mr-16 flex w-full max-w-xs flex-1"
                        >
                            <TransitionChild
                                as="template"
                                enter="ease-in-out duration-300"
                                enter-from="opacity-0"
                                enter-to=""
                                leave="ease-in-out duration-300"
                                leave-from=""
                                leave-to="opacity-0"
                            >
                                <div
                                    class="absolute top-0 left-full flex w-16 justify-center pt-5"
                                >
                                    <button
                                        type="button"
                                        class="-m-2.5 p-2.5"
                                        @click="sidebarOpen = false"
                                    >
                                        <span class="sr-only"
                                            >Close sidebar</span
                                        >
                                        <XMarkIcon
                                            class="size-6 text-white"
                                            aria-hidden="true"
                                        />
                                    </button>
                                </div>
                            </TransitionChild>

                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div
                                class="relative flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring ring-white/10 before:pointer-events-none before:absolute before:inset-0 before:bg-black/10"
                            >
                                <div
                                    class="relative flex h-16 shrink-0 items-center"
                                >
                                    <img
                                        class="h-8 w-auto"
                                        src="/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                                        alt="Your Company"
                                    />
                                </div>
                                <nav class="relative flex flex-1 flex-col">
                                    <ul
                                        role="list"
                                        class="flex flex-1 flex-col gap-y-7"
                                    >
                                        <li>
                                            <ul
                                                role="list"
                                                class="-mx-2 space-y-1"
                                            >
                                                <li
                                                    v-for="item in navigation"
                                                    :key="item.name"
                                                >
                                                    <a
                                                        :href="item.href"
                                                        :class="[
                                                            item.current
                                                                ? 'bg-white/5 text-white'
                                                                : 'text-gray-400 hover:bg-white/5 hover:text-white',
                                                            'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                                                        ]"
                                                    >
                                                        <component
                                                            :is="item.icon"
                                                            :class="[
                                                                item.current
                                                                    ? 'text-white'
                                                                    : 'text-gray-400 group-hover:text-white',
                                                                'size-6 shrink-0',
                                                            ]"
                                                            aria-hidden="true"
                                                        />
                                                        {{ item.name }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div
                                                class="text-xs/6 font-semibold text-gray-400"
                                            >
                                                Your teams
                                            </div>
                                            <ul
                                                role="list"
                                                class="-mx-2 mt-2 space-y-1"
                                            >
                                                <li
                                                    v-for="team in teams"
                                                    :key="team.name"
                                                >
                                                    <a
                                                        :href="team.href"
                                                        :class="[
                                                            team.current
                                                                ? 'bg-white/5 text-white'
                                                                : 'text-gray-400 hover:bg-white/5 hover:text-white',
                                                            'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                                                        ]"
                                                    >
                                                        <span
                                                            :class="[
                                                                team.current
                                                                    ? 'border-white/20 text-white'
                                                                    : 'border-white/10 text-gray-400 group-hover:border-white/20 group-hover:text-white',
                                                                'flex size-6 shrink-0 items-center justify-center rounded-lg border bg-white/5 text-[0.625rem] font-medium',
                                                            ]"
                                                            >{{
                                                                team.initial
                                                            }}</span
                                                        >
                                                        <span
                                                            class="truncate"
                                                            >{{
                                                                team.name
                                                            }}</span
                                                        >
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mt-auto">
                                            <a
                                                href="#"
                                                class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-300 hover:bg-white/5 hover:text-white"
                                            >
                                                <Cog6ToothIcon
                                                    class="size-6 shrink-0 text-gray-400 group-hover:text-white"
                                                    aria-hidden="true"
                                                />
                                                Settings
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div
            class="hidden bg-gray-900 lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col"
        >
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div
                class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-white/10 bg-black/10 px-6 pb-4"
            >
                <div class="flex h-16 shrink-0 items-center">
                    <img
                        class="h-8 w-auto"
                        src="/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                        alt="Your Company"
                    />
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li>
                                    <a
                                        :href="route('admin.dashboard')"
                                        :class="[
                                            routeName == 'admin.dashboard'
                                                ? 'bg-white/5 text-white'
                                                : 'text-gray-400 hover:bg-white/5 hover:text-white',
                                            'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                                        ]"
                                    >
                                        <component
                                            :is="dashboard_menu.icon"
                                            :class="[
                                                routeName == 'admin.dashboard'
                                                    ? 'text-white'
                                                    : 'text-gray-400 group-hover:text-white',
                                                'size-6 shrink-0',
                                            ]"
                                            aria-hidden="true"
                                        />
                                        {{ dashboard_menu.name }}
                                    </a>
                                </li>
                                <li>
                                    <Menu as="div" class="">
                                        <MenuButton
                                            :class="[
                                                [
                                                    'admin.jobs.active',
                                                    'admin.jobs.pause',
                                                    'admin.jobs.finished',
                                                    'admin.jobs.canceled',
                                                ].includes(routeName)
                                                    ? 'bg-white/5 text-white'
                                                    : 'text-gray-400',
                                                'inline-flex w-full justify-start gap-x-3 rounded-md p-2 py-2 text-sm font-semibold hover:bg-white/20',
                                            ]"
                                        >
                                            <component
                                                :is="BriefcaseIcon"
                                                :class="['size-6 shrink-0']"
                                                aria-hidden="true"
                                            />
                                            Jobs
                                            <ChevronRightIcon
                                                class="ml-auto -mr-1 size-5 text-gray-400"
                                                aria-hidden="true"
                                            />
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
                                                class="my-2 w-full rounded-md bg-gray-800 outline-1 -outline-offset-1 outline-white/10"
                                            >
                                                <div class="py-1">
                                                    <MenuItem
                                                        v-slot="{ active }"
                                                    >
                                                        <a
                                                            :href="
                                                                route(
                                                                    'admin.jobs.active'
                                                                )
                                                            "
                                                            :class="[
                                                                active
                                                                    ? 'bg-white/5 text-white outline-hidden'
                                                                    : 'text-gray-300',
                                                                'block px-4 py-2 text-sm',
                                                            ]"
                                                            >Active Jobs</a
                                                        >
                                                    </MenuItem>
                                                    <MenuItem
                                                        v-slot="{ active }"
                                                    >
                                                        <a
                                                            :href="
                                                                route(
                                                                    'admin.jobs.pause'
                                                                )
                                                            "
                                                            :class="[
                                                                active
                                                                    ? 'bg-white/5 text-white outline-hidden'
                                                                    : 'text-gray-300',
                                                                'block px-4 py-2 text-sm',
                                                            ]"
                                                            >Jobs On hold</a
                                                        >
                                                    </MenuItem>
                                                    <MenuItem
                                                        v-slot="{ active }"
                                                    >
                                                        <a
                                                            :href="
                                                                route(
                                                                    'admin.jobs.finished'
                                                                )
                                                            "
                                                            :class="[
                                                                active
                                                                    ? 'bg-white/5 text-white outline-hidden'
                                                                    : 'text-gray-300',
                                                                'block px-4 py-2 text-sm',
                                                            ]"
                                                            >Finished</a
                                                        >
                                                    </MenuItem>
                                                    <form
                                                        method="POST"
                                                        action="#"
                                                    >
                                                        <MenuItem
                                                            v-slot="{ active }"
                                                        >
                                                            <a
                                                                :href="
                                                                    route(
                                                                        'admin.jobs.canceled'
                                                                    )
                                                                "
                                                                :class="[
                                                                    active
                                                                        ? 'bg-white/5 text-white outline-hidden'
                                                                        : 'text-gray-300',
                                                                    'block w-full px-4 py-2 text-left text-sm',
                                                                ]"
                                                            >
                                                                Canceled
                                                            </a>
                                                        </MenuItem>
                                                    </form>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                </li>
                                <li v-for="item in navigation" :key="item.name">
                                    <a
                                        :href="item.href"
                                        :class="[
                                            item.RName == routeName
                                                ? 'bg-white/5 text-white'
                                                : 'text-gray-400 hover:bg-white/5 hover:text-white',
                                            'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                                        ]"
                                    >
                                        <component
                                            :is="item.icon"
                                            :class="[
                                                item.current
                                                    ? 'text-white'
                                                    : 'text-gray-400 group-hover:text-white',
                                                'size-6 shrink-0',
                                            ]"
                                            aria-hidden="true"
                                        />
                                        {{ item.name }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="mt-auto">
                            <a
                                href="#"
                                class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-300 hover:bg-white/5 hover:text-white"
                            >
                                <Cog6ToothIcon
                                    class="size-6 shrink-0 text-gray-400 group-hover:text-white"
                                    aria-hidden="true"
                                />
                                Settings
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="lg:pl-72">
            <Navbar />
            <main class="py-2">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped></style>
