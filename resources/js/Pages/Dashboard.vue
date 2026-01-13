<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from "@headlessui/vue";
import {
    ArrowDownCircleIcon,
    ArrowPathIcon,
    ArrowUpCircleIcon,
    Bars3Icon,
    EllipsisHorizontalIcon,
    PlusSmallIcon,
} from "@heroicons/vue/20/solid";
import { BellIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import Main from "@/Layouts/Main.vue";

const props = defineProps({
    Revenue: Number,
    Receivables: Number,
    TotalEspenses: Number,
    TotalDebts: Number,
    TodayActivitiesArr: Array,
    NotTodayActivitiesArr: Array,
});

const formatRupiah = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 2,
    }).format(number);
};

const navigation = [
    { name: "Home", href: "#" },
    { name: "Invoices", href: "#" },
    { name: "Clients", href: "#" },
    { name: "Expenses", href: "#" },
];

const secondaryNavigation = [
    { name: "Last 30 days", href: "javascript:void(0)", current: true },
];

const stats = [
    {
        name: "Revenue (Pendapatan)",
        value: formatRupiah(props.Revenue),
        change: "+0%",
        changeType: "positive",
    },
    {
        name: "Expenses (Pengeluaran)",
        value: formatRupiah(props.TotalEspenses),
        change: "+0%",
        changeType: "positive",
    },
    {
        name: "Receivables (Piutang)",
        value: formatRupiah(props.Receivables),
        change: "+0%",
        changeType: "positive",
    },
    {
        name: "Debt (Hutang)",
        value: formatRupiah(props.TotalDebts),
        change: "-0%",
        changeType: "positive",
    },
];

const statuses = {
    Paid: "bg-green-500/10 text-green-500 ring-green-500/10",
    Withdraw: "bg-white/5 text-gray-400 ring-white/10",
    Overdue: "bg-red-500/10 text-red-400 ring-red-500/10",
};

const days = [
    {
        date: "Today",
        dateTime: "2023-03-22",
        transactions: props.TodayActivitiesArr,
    },
    {
        date: "Yesterday",
        dateTime: "2023-03-21",
        transactions: props.NotTodayActivitiesArr,
    },
];

const mobileMenuOpen = ref(false);
</script>

<template>
    <Head title="Dashboard" />
    <Main>
        <div class="relative isolate overflow-hidden">
            <!-- Secondary navigation -->
            <header class="pt-6 pb-4 sm:pb-6">
                <div
                    class="mx-auto flex max-w-7xl flex-wrap items-center gap-6 px-4 sm:flex-nowrap sm:px-6 lg:px-8"
                >
                    <h1 class="text-base/7 font-semibold text-white">
                        Cashflow
                    </h1>
                    <div
                        class="order-last flex w-full gap-x-8 text-sm/6 font-semibold sm:order-0 sm:w-auto sm:border-l sm:border-white/10 sm:pl-6 sm:text-sm/7"
                    >
                        <a
                            v-for="item in secondaryNavigation"
                            :key="item.name"
                            :href="item.href"
                            :class="
                                item.current
                                    ? 'text-indigo-400'
                                    : 'text-gray-300'
                            "
                            >{{ item.name }}</a
                        >
                    </div>
                </div>
            </header>

            <!-- Stats -->
            <div
                class="border-b border-b-white/10 lg:border-t lg:border-t-white/5"
            >
                <dl
                    class="mx-auto grid max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 lg:px-2 xl:px-0"
                >
                    <div
                        v-for="(stat, statIdx) in stats"
                        :key="stat.name"
                        :class="[
                            statIdx % 2 === 1
                                ? 'sm:border-l'
                                : statIdx === 2
                                ? 'lg:border-l'
                                : '',
                            'flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 border-t border-white/5 px-4 py-10 sm:px-6 lg:border-t-0 xl:px-8',
                        ]"
                    >
                        <dt class="text-sm/6 font-medium text-gray-400">
                            {{ stat.name }}
                        </dt>
                        <dd
                            :class="[
                                stat.changeType === 'negative'
                                    ? 'text-rose-400'
                                    : 'text-gray-300',
                                'text-xs font-medium',
                            ]"
                        >
                            {{ stat.change }}
                        </dd>
                        <dd
                            class="w-full flex-none text-3xl/10 font-medium tracking-tight text-white"
                        >
                            {{ stat.value }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div
                class="absolute top-full left-0 -z-10 mt-96 origin-top-left translate-y-40 -rotate-90 transform-gpu opacity-10 blur-3xl sm:left-1/2 sm:-mt-10 sm:-ml-96 sm:translate-y-0 sm:rotate-0 sm:opacity-30"
                aria-hidden="true"
            >
                <div
                    class="aspect-1154/678 w-288.5 bg-linear-to-br from-[#FF80B5] to-[#9089FC]"
                    style="
                        clip-path: polygon(
                            100% 38.5%,
                            82.6% 100%,
                            60.2% 37.7%,
                            52.4% 32.1%,
                            47.5% 41.8%,
                            45.2% 65.6%,
                            27.5% 23.4%,
                            0.1% 35.3%,
                            17.9% 0%,
                            27.7% 23.4%,
                            76.2% 2.5%,
                            74.2% 56%,
                            100% 38.5%
                        );
                    "
                />
            </div>
        </div>

        <div class="space-y-16 py-16 xl:space-y-20">
            <!-- Recent activity table -->
            <div>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2
                        class="mx-auto max-w-2xl text-base font-semibold text-white lg:mx-0 lg:max-w-none"
                    >
                        Recent activity
                    </h2>
                </div>
                <div class="mt-6 overflow-hidden border-t border-white/5">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                            <table class="w-full text-left">
                                <thead class="sr-only">
                                    <tr>
                                        <th>Amount</th>
                                        <th class="hidden sm:table-cell">
                                            Client
                                        </th>
                                        <th>More details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-for="day in days"
                                        :key="day.dateTime"
                                    >
                                        <tr class="text-sm/6 text-white">
                                            <th
                                                scope="colgroup"
                                                colspan="3"
                                                class="relative isolate py-2 font-semibold"
                                            >
                                                <time
                                                    :datetime="day.dateTime"
                                                    >{{ day.date }}</time
                                                >
                                                <div
                                                    class="absolute inset-y-0 right-full -z-10 w-screen border-b border-white/10 bg-white/2.5"
                                                />
                                                <div
                                                    class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-white/10 bg-white/2.5"
                                                />
                                            </th>
                                        </tr>
                                        <tr
                                            v-for="transaction in day.transactions"
                                            :key="transaction.id"
                                        >
                                            <td class="relative py-5 pr-6">
                                                <div class="flex gap-x-6">
                                                    <component
                                                        v-if="
                                                            transaction.icon ==
                                                            'ArrowDownCircleIcon'
                                                        "
                                                        :is="
                                                            ArrowDownCircleIcon
                                                        "
                                                        class="hidden h-6 w-5 flex-none text-green-500 sm:block"
                                                        aria-hidden="true"
                                                    />
                                                    <component
                                                        v-if="
                                                            transaction.icon ==
                                                            'ArrowUpCircleIcon'
                                                        "
                                                        :is="ArrowUpCircleIcon"
                                                        class="hidden h-6 w-5 flex-none text-red-500 sm:block"
                                                        aria-hidden="true"
                                                    />
                                                    <div class="flex-auto">
                                                        <div
                                                            class="flex items-start gap-x-3"
                                                        >
                                                            <div
                                                                class="text-sm/6 font-medium text-white"
                                                            >
                                                                {{
                                                                    formatRupiah(
                                                                        transaction.amount
                                                                    )
                                                                }}
                                                            </div>
                                                            <div
                                                                :class="[
                                                                    'rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                                                                    transaction.status ==
                                                                    'income'
                                                                        ? 'text-green-500 ring-green-500/20'
                                                                        : 'text-red-500 ring-red-500/20',
                                                                ]"
                                                            >
                                                                {{
                                                                    transaction.status
                                                                }}
                                                            </div>
                                                        </div>
                                                        <div
                                                            v-if="
                                                                transaction.tax
                                                            "
                                                            class="mt-1 text-xs/5 text-gray-400"
                                                        >
                                                            {{
                                                                transaction.tax
                                                            }}
                                                            tax
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="absolute right-full bottom-0 h-px w-screen bg-white/5"
                                                />
                                                <div
                                                    class="absolute bottom-0 left-0 h-px w-screen bg-white/5"
                                                />
                                            </td>
                                            <td
                                                class="hidden py-5 pr-6 sm:table-cell"
                                            >
                                                <div
                                                    class="text-sm/6 text-white"
                                                >
                                                    {{ transaction.client }}
                                                </div>
                                                <div
                                                    class="mt-1 text-xs/5 text-gray-400"
                                                >
                                                    {{
                                                        transaction.description
                                                    }}
                                                </div>
                                            </td>
                                            <td class="py-5 text-right">
                                                <div class="flex justify-end">
                                                    <a
                                                        :href="transaction.href"
                                                        class="text-sm/6 font-medium text-indigo-400 hover:text-indigo-300"
                                                        >View<span
                                                            class="hidden sm:inline"
                                                        >
                                                            transaction</span
                                                        ><span class="sr-only"
                                                            >, invoice #{{
                                                                transaction.invoiceNumber
                                                            }},
                                                            {{
                                                                transaction.client
                                                            }}</span
                                                        ></a
                                                    >
                                                </div>
                                                <div
                                                    class="mt-1 text-xs/5 text-gray-400"
                                                >
                                                    Invoice
                                                    <span class="text-white"
                                                        >#{{
                                                            transaction.invoiceNumber
                                                        }}</span
                                                    >
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Main>
</template>

<style scoped></style>
