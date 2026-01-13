<script setup>
import Main from "@/Layouts/Main.vue";
import { Head, router } from "@inertiajs/vue3";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { MagnifyingGlassCircleIcon } from "@heroicons/vue/16/solid";
import { ref, computed, defineProps } from "vue";
import { UseNotification } from "@/Composables/UseNotification";
const { addNotify } = UseNotification();

const props = defineProps({
    jobs: Array,
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
const filteredJobs = computed(() => {
    // Jika kolom search kosong, tampilkan semua jobs
    if (!searchQuery.value) {
        return props.jobs;
    }

    const query = searchQuery.value.toLowerCase();

    return props.jobs.filter((job) => {
        // Cari berdasarkan judul pekerjaan (title) atau kriteria lainnya
        return (
            job.cust_name.toLowerCase().includes(query) ||
            job.job_name?.toLowerCase().includes(query)
        );
    });
});

const Finish = async (id) => {
    const payload = {
        id: id,
    };

    try {
        const response = await axios.post("/api/finish-jobs", payload);
        addNotify(response.data.message, "success", true);
        router.reload({
            only: ["jobs"],
        });
    } catch (error) {
        const errorMessage =
            error.response?.data?.message || "Terjadi kesalahan pada sistem.";
        console.error("Detail Error:", error.response?.data);
        addNotify(errorMessage, "error");
    }
};

const Paused = async (id) => {
    const payload = {
        id: id,
    };

    try {
        const response = await axios.post("/api/pause-jobs", payload);
        addNotify(response.data.message, "success", true);
        router.reload({
            only: ["jobs"],
        });
    } catch (error) {
        const errorMessage =
            error.response?.data?.message || "Terjadi kesalahan pada sistem.";
        console.error("Detail Error:", error.response?.data);
        addNotify(errorMessage, "error");
    }
};

const Cancel = async (id) => {
    const payload = {
        id: id,
    };

    try {
        const response = await axios.post("/api/cancel-jobs", payload);
        addNotify(response.data.message, "success", true);
        router.reload({
            only: ["jobs"],
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
    <Head title="Active Jobs" />
    <Main>
        <header class="pt-6 pb-4 sm:pb-6">
            <div
                class="mx-auto flex max-w-7xl flex-wrap items-center gap-6 px-4 sm:flex-nowrap sm:px-6 lg:px-8"
            >
                <h1 class="text-base/7 font-semibold text-white">
                    Active Jobs
                </h1>
            </div>
        </header>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-white">Jobs</h1>
                    <p class="mt-2 text-sm text-gray-300">
                        Pekerjaan yang
                        <strong class="font-semibold text-white"
                            >aktif saat ini</strong
                        >. Range pekerjaan standart Rp 500.000, Per Fitur Rp
                        50.000.
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a
                        :href="route('admin.jobs.add')"
                        class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                    >
                        Tambah Pekerjaan
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
                                class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-white sm:pl-6"
                            >
                                Customer
                            </th>
                            <th
                                scope="col"
                                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-white lg:table-cell"
                            >
                                Nama Pekerjaan
                            </th>
                            <th
                                scope="col"
                                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-white lg:table-cell"
                            >
                                Due Date
                            </th>
                            <th
                                scope="col"
                                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-white lg:table-cell"
                            >
                                Harga
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-white"
                            >
                                Progres
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
                        <template v-if="jobs.length > 0">
                            <tr
                                v-for="(job, jobIdx) in filteredJobs"
                                :key="job.id"
                            >
                                <td
                                    class="border-t border-white/10 text-gray-400 relative py-4 pr-3 pl-4 text-sm sm:pl-6"
                                >
                                    {{ job.cust_name }}
                                </td>
                                <td
                                    class="border-t border-white/10 text-white relative py-4 pr-3 pl-4 text-sm sm:pl-6"
                                >
                                    {{ job.job_name }}
                                </td>
                                <td
                                    class="border-t border-white/10 px-3 py-3.5 text-sm text-white lg:table-cell"
                                >
                                    {{ job.due_date }}
                                </td>
                                <td
                                    class="border-t border-white/10 text-gray-400 relative py-4 pr-3 pl-4 text-sm sm:pl-6"
                                >
                                    {{ formatRupiah(job.price) }}
                                </td>
                                <td
                                    class="border-t border-white/10 px-3 py-3.5 text-sm text-white lg:table-cell"
                                >
                                    {{ job.status }}
                                </td>
                                <td
                                    :class="[
                                        jobIdx === 0
                                            ? ''
                                            : 'border-t border-transparent',
                                        'relative py-3.5 pr-4 pl-3 text-center text-sm font-medium sm:pr-6',
                                    ]"
                                >
                                    <Menu
                                        as="div"
                                        class="relative inline-block"
                                    >
                                        <MenuButton
                                            class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring-1 inset-ring-white/5 hover:bg-white/20"
                                        >
                                            Aksi
                                            <ChevronDownIcon
                                                class="-mr-1 size-5 text-gray-400"
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
                                                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-gray-800 outline-1 -outline-offset-1 outline-white/10"
                                            >
                                                <div class="py-1">
                                                    <MenuItem
                                                        v-slot="{ active }"
                                                    >
                                                        <a
                                                            href="javascript:void(0)"
                                                            @click="
                                                                Finish(job.id)
                                                            "
                                                            :class="[
                                                                active
                                                                    ? 'bg-white/5 text-white outline-hidden'
                                                                    : 'text-gray-300',
                                                                'block px-4 py-2 text-left text-sm',
                                                            ]"
                                                            >Finish</a
                                                        >
                                                    </MenuItem>
                                                    <MenuItem
                                                        v-slot="{ active }"
                                                    >
                                                        <a
                                                            href="javascript:void(0)"
                                                            @click="
                                                                Paused(job.id)
                                                            "
                                                            :class="[
                                                                active
                                                                    ? 'bg-white/5 text-white outline-hidden'
                                                                    : 'text-gray-300',
                                                                'block px-4 py-2 text-left text-sm',
                                                            ]"
                                                            >Pause</a
                                                        >
                                                    </MenuItem>
                                                    <MenuItem
                                                        v-slot="{ active }"
                                                    >
                                                        <a
                                                            href="javascript:void(0)"
                                                            @click="
                                                                Cancel(job.id)
                                                            "
                                                            :class="[
                                                                active
                                                                    ? 'bg-white/5 text-white outline-hidden'
                                                                    : 'text-gray-300',
                                                                'block px-4 py-2 text-left text-sm',
                                                            ]"
                                                            >Cancel</a
                                                        >
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                    <div
                                        v-if="jobIdx !== 0"
                                        class="absolute -top-px right-6 left-0 h-px bg-white/10"
                                    />
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td
                                colspan="6"
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
