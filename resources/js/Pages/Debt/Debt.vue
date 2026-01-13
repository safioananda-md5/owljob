<script setup>
import Main from "@/Layouts/Main.vue";
import { Head, router } from "@inertiajs/vue3";
import { MagnifyingGlassCircleIcon } from "@heroicons/vue/16/solid";
import { computed, ref, defineProps } from "vue";
import { UseNotification } from "@/Composables/UseNotification";
const { addNotify } = UseNotification();

const props = defineProps({
    debtsArr: Array,
});

const formatRupiah = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(number);
};

// 1. Variabel penampung teks yang diketik di search
const searchQuery = ref("");

// 2. Logika filter menggunakan computed property
const filtereddebts = computed(() => {
    // Jika kolom search kosong, tampilkan semua jobs
    if (!searchQuery.value) {
        return props.debtsArr;
    }

    const query = searchQuery.value.toLowerCase();

    return props.debtsArr.filter((debt) => {
        // Cari berdasarkan judul pekerjaan (title) atau kriteria lainnya
        return (
            debt.name.toLowerCase().includes(query) ||
            debt.amount.includes(query)
        );
    });
});

const Delete = async (id) => {
    const payload = {
        id: id,
    };

    try {
        const response = await axios.post("/api/delete-debts", payload);
        addNotify(response.data.message, "success", true);
        router.reload({
            only: ["debtsArr"],
        });
    } catch (error) {
        const errorMessage =
            error.response?.data?.message || "Terjadi kesalahan pada sistem.";
        console.error("Detail Error:", error.response?.data);
        addNotify(errorMessage, "error");
    }
};
</script>

<template>
    <Head title="Debt (Hutang)" />
    <Main>
        <header class="pt-6 pb-4 sm:pb-6">
            <div
                class="mx-auto flex max-w-7xl flex-wrap items-center gap-6 px-4 sm:flex-nowrap sm:px-6 lg:px-8"
            >
                <h1 class="text-base/7 font-semibold text-white">
                    Debt (Hutang)
                </h1>
            </div>
        </header>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-white">Debt</h1>
                    <p class="mt-2 text-sm text-gray-300">Hutang selama ini.</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a
                        :href="route('admin.debt.add')"
                        class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                    >
                        Tambah Hutang
                    </a>
                </div>
            </div>
            <div class="mt-10">
                <div class="mt-2 grid grid-cols-1">
                    <input
                        type="text"
                        v-model="searchQuery"
                        id="search"
                        class="col-start-1 row-start-1 block w-50 rounded-md bg-white/5 py-1.5 pr-3 pl-10 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:pl-9 sm:text-sm/6"
                        placeholder="Cari disini.."
                    />
                    <MagnifyingGlassCircleIcon
                        class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-500 sm:size-4"
                        aria-hidden="true"
                    />
                </div>
            </div>
            <div class="-mx-4 mt-5 ring-1 ring-white/15 sm:mx-0 sm:rounded-lg">
                <table class="relative min-w-full divide-y divide-white/15">
                    <thead>
                        <tr>
                            <th
                                scope="col"
                                class="py-3.5 pr-3 pl-4 text-center text-sm font-semibold text-white"
                            >
                                Amount
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3.5 text-center text-sm font-semibold text-white"
                            >
                                Description
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3.5 text-center text-sm font-semibold text-white"
                            >
                                Date
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3.5 text-center text-sm font-semibold text-white"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="filtereddebts.length > 0">
                            <tr
                                v-for="(debt, debtIdx) in filtereddebts"
                                :key="debt.id"
                            >
                                <td
                                    class="border-t border-white/10 text-center text-gray-400 relative py-4 pr-3 pl-4 text-sm sm:pl-6"
                                >
                                    {{ formatRupiah(debt.amount) }}
                                </td>
                                <td
                                    class="border-t border-white/10 text-center text-gray-400 relative py-4 pr-3 pl-4 text-sm sm:pl-6"
                                >
                                    {{ debt.name }}
                                </td>
                                <td
                                    class="border-t border-white/10 text-center text-gray-400 relative py-4 pr-3 pl-4 text-sm sm:pl-6"
                                >
                                    {{ debt.date }}
                                </td>
                                <td
                                    class="border-t border-white/10 text-center text-gray-400 relative py-4 pr-3 pl-4 text-sm sm:pl-6"
                                >
                                    <button
                                        type="button"
                                        @click="Delete(debt.id)"
                                        class="block rounded-md bg-red-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-red-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                                    >
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td
                                colspan="4"
                                class="border-t border-white/10 text-gray-400 relative py-4 pr-3 pl-4 text-sm sm:pl-6 text-center"
                            >
                                Tidak ada data tersedia
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <nav
                class="flex items-center justify-between border-t border-white/10 px-4 sm:px-0"
            >
                <div class="-mt-px flex w-0 flex-1">
                    <a
                        href="#"
                        class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-400 hover:border-white/20 hover:text-gray-200"
                    >
                        <ArrowLongLeftIcon
                            class="mr-3 size-5 text-gray-500"
                            aria-hidden="true"
                        />
                        Previous
                    </a>
                </div>
                <div class="hidden md:-mt-px md:flex">
                    <a
                        href="#"
                        class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-400 hover:border-white/20 hover:text-gray-200"
                        >1</a
                    >
                    <a
                        href="#"
                        class="inline-flex items-center border-t-2 border-indigo-400 px-4 pt-4 text-sm font-medium text-indigo-400"
                        aria-current="page"
                        >2</a
                    >
                    <a
                        href="#"
                        class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-400 hover:border-white/20 hover:text-gray-200"
                        >3</a
                    >
                    <span
                        class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500"
                        >...</span
                    >
                    <a
                        href="#"
                        class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-400 hover:border-white/20 hover:text-gray-200"
                        >8</a
                    >
                    <a
                        href="#"
                        class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-400 hover:border-white/20 hover:text-gray-200"
                        >9</a
                    >
                    <a
                        href="#"
                        class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-400 hover:border-white/20 hover:text-gray-200"
                        >10</a
                    >
                </div>
                <div class="-mt-px flex w-0 flex-1 justify-end">
                    <a
                        href="#"
                        class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-400 hover:border-white/20 hover:text-gray-200"
                    >
                        Next
                        <ArrowLongRightIcon
                            class="ml-3 size-5 text-gray-500"
                            aria-hidden="true"
                        />
                    </a>
                </div>
            </nav> -->
        </div>
    </Main>
</template>

<style scoped></style>
