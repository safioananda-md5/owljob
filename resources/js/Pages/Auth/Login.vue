<script setup>
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    password: "",
});

const submit = () => {
    form.post(route("post.login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Login" />
    <div
        class="flex min-h-screen flex-1 items-center justify-center px-4 py-12 sm:px-6 lg:px-8"
    >
        <div class="w-full max-w-sm space-y-10">
            <div>
                <img
                    class="mx-auto h-10 w-auto dark:hidden"
                    src="/img/logos/laravel-logo-gray-400.svg"
                    alt="Your Company"
                />
                <img
                    class="mx-auto h-10 w-auto not-dark:hidden"
                    src="/img/logos/laravel-logo-gray-400.svg"
                    alt="Your Company"
                />
                <h2
                    class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    Sign in to your account
                </h2>
            </div>
            <form class="space-y-6" @submit.prevent="submit" method="POST">
                <div>
                    <div class="col-span-2">
                        <input
                            id="email-address"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required=""
                            aria-label="Email address"
                            class="block w-full rounded-t-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:relative focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-gray-700 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500"
                            placeholder="Email address"
                        />
                    </div>
                    <div class="-mt-px">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required=""
                            aria-label="Password"
                            class="block w-full rounded-b-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:relative focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-gray-700 dark:placeholder:text-gray-500 dark:focus:outline-indigo-500"
                            placeholder="Password"
                        />
                    </div>
                </div>

                <div>
                    <a
                        :href="route('admin.dashboard')"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500"
                    >
                        Sign in
                    </a>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped></style>
