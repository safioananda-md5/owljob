<script setup>
import Main from "@/Layouts/Main.vue";
import { Head } from "@inertiajs/vue3";
import { reactive } from "vue";
import { ref, onMounted, onBeforeUnmount } from "vue";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import axios from "axios";
import {
    CalendarDateRangeIcon,
    CalendarDaysIcon,
} from "@heroicons/vue/16/solid";
import { UseNotification } from "@/Composables/UseNotification";
const { addNotify } = UseNotification();

const form = reactive({
    cust_name: "",
    job_name: "",
    due_date: "",
    price_show: "",
    price: "",
});

const due_date_input = ref(null);
let fp = null;

const today = () => {
    const d = new Date();
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, "0");
    const day = String(d.getDate()).padStart(2, "0");
    const formattedDate = `${year}-${month}-${day}`;
    form.due_date = formattedDate;
};

const rupiah = (value) => {
    let numberString = value.replace(/[^0-9]/g, "");
    if (!numberString) return "";
    const numberValue = parseInt(numberString, 10);
    return new Intl.NumberFormat("id-ID").format(numberValue);
};

const handleRupiahInput = (event) => {
    const inputVal = event.target.value;
    form.price_show = rupiah(inputVal);
    form.price = inputVal.replace(/[^0-9]/g, "");
};

onMounted(() => {
    fp = flatpickr(due_date_input.value, {
        dateFormat: "Y-m-d",
        onChange: (selectedDates, dateStr) => {
            form.due_date = dateStr;
        },
    });
});

onBeforeUnmount(() => {
    if (fp) fp.destroy();
});

const resetForm = () => {
    form.cust_name = "";
    form.job_name = "";
    form.due_date = "";
    form.price_show = "";
    form.price = "";
};

const isLoading = ref(false);
const submitForm = async () => {
    isLoading.value = true;

    // Data yang dikirim ke Laravel
    const payload = {
        cust_name: form.cust_name,
        job_name: form.job_name,
        due_date: form.due_date,
        price: form.price,
    };

    try {
        const response = await axios.post("/api/new-jobs", payload);
        addNotify(response.data.message, "success");
        resetForm();
    } catch (error) {
        const errorMessage =
            error.response?.data?.message || "Terjadi kesalahan pada sistem.";
        console.error("Detail Error:", error.response?.data);
        addNotify(errorMessage, "error");
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <Head title="Add Jobs" />
    <Main>
        <header class="pt-6 pb-4 sm:pb-6">
            <div class="mx-auto sm:px-6 lg:px-8">
                <h1 class="text-base/7 font-semibold text-white">
                    Add New Jobs
                </h1>
                <small class="text-white italic">
                    <span style="color: red">*</span>
                    Menandakan kolom wajib diisi atau dipilih.
                </small>
            </div>
        </header>

        <form
            @submit.prevent="submitForm"
            method="POST"
            class="mx-auto sm:px-6 lg:px-8"
        >
            <div class="mb-3">
                <label
                    for="cust_name"
                    class="block text-sm/6 font-medium text-gray-900 dark:text-white"
                    >Nama Customer <span style="color: red">*</span></label
                >
                <div class="mt-2">
                    <input
                        type="text"
                        v-model="form.cust_name"
                        id="cust_name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500"
                        placeholder="Kharisma Safio Ananda"
                    />
                </div>
            </div>
            <div class="mb-3">
                <label
                    for="job_name"
                    class="block text-sm/6 font-medium text-gray-900 dark:text-white"
                    >Nama Pekerjaan <span style="color: red">*</span></label
                >
                <div class="mt-2">
                    <input
                        type="text"
                        v-model="form.job_name"
                        id="job_name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500"
                        placeholder="Aplikasi SPK Rutilahu Kel. Alun-Alun Contong Surabaya"
                    />
                </div>
            </div>
            <div class="mb-3">
                <label
                    for="due_date"
                    class="block text-sm/6 font-medium text-gray-900 dark:text-white"
                    >Due Date <span style="color: red">*</span></label
                >
                <div class="mt-2 flex">
                    <div
                        class="-mr-px grid grow grid-cols-1 focus-within:relative"
                    >
                        <input
                            ref="due_date_input"
                            type="text"
                            v-model="form.due_date"
                            id="due_date"
                            class="col-start-1 row-start-1 block w-full rounded-l-md bg-white py-1.5 pr-3 pl-10 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:pl-9 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-gray-700 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500"
                            placeholder="Pilih Due Date (Y-m-d)"
                        />
                        <CalendarDateRangeIcon
                            class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400 sm:size-4 dark:text-gray-500"
                            aria-hidden="true"
                        />
                    </div>
                    <button
                        type="button"
                        @click="today"
                        class="flex shrink-0 items-center gap-x-1.5 rounded-r-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 outline-1 -outline-offset-1 outline-gray-300 hover:bg-gray-50 focus:relative focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 dark:bg-white/10 dark:text-white dark:outline-gray-700 dark:hover:bg-white/20 dark:focus:outline-indigo-500"
                    >
                        <CalendarDaysIcon
                            class="-ml-0.5 size-4 text-gray-400"
                            aria-hidden="true"
                        />
                        Today
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label
                    for="price"
                    class="block text-sm/6 font-medium text-white"
                    >Harga</label
                >
                <div class="mt-2">
                    <div
                        class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-gray-600 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-500"
                    >
                        <div
                            class="shrink-0 pe-1 text-base text-gray-400 select-none sm:text-sm/6"
                        >
                            Rp
                        </div>
                        <input
                            type="text"
                            v-model="form.price_show"
                            @input="handleRupiahInput"
                            id="price"
                            class="block min-w-0 grow bg-gray-800 py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6"
                            placeholder="0"
                        />
                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a
                    type="button"
                    class="text-sm/6 font-semibold text-white"
                    :href="route('admin.jobs.active')"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    :disabled="isLoading"
                    class="inline-flex items-center px-6 py-3 font-semibold leading-6 text-sm shadow rounded-md text-white transition ease-in-out duration-150"
                    :class="
                        isLoading
                            ? 'bg-blue-400 cursor-not-allowed'
                            : 'bg-blue-600 hover:bg-blue-700'
                    "
                >
                    <svg
                        v-if="isLoading"
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>

                    <span v-if="isLoading">Process...</span>
                    <span v-else>Add Jobs</span>
                </button>
            </div>
        </form>
    </Main>
</template>

<style scoped></style>
