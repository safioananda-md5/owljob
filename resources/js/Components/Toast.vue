<script setup>
import { ref, watch } from "vue";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/outline";
import { XMarkIcon } from "@heroicons/vue/20/solid";
import { UseNotification } from "@/Composables/UseNotification";

const { notifications, removeNotify } = UseNotification();

// watch(notifications.value, (newId) => {
//     notifications.value.forEach((item, index) => {
//         if (item.reload) {
//             router.reload();
//             // console.log("Reload True ", item);
//         }
//     });
// });
</script>

<template>
    <div
        aria-live="assertive"
        class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 z-50"
    >
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
            <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
            <transition-group
                enter-active-class="transform ease-out duration-300 transition"
                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 sm:translate-x-0"
                leave-active-class="transition ease-in duration-100"
                leave-from-class=""
                leave-to-class="opacity-0"
            >
                <div
                    v-for="item in notifications"
                    :key="item.id"
                    class="toast-card pointer-events-auto w-full max-w-sm rounded-lg bg-white shadow-lg outline-1 outline-black/5 dark:bg-gray-800 dark:-outline-offset-1 dark:outline-white/10"
                >
                    <div class="pt-4">
                        <div class="flex items-start px-4">
                            <div class="shrink-0">
                                <CheckCircleIcon
                                    class="size-6 text-green-400"
                                    aria-hidden="true"
                                    v-if="item.type === 'success'"
                                />

                                <XCircleIcon
                                    class="size-6 text-red-400"
                                    aria-hidden="true"
                                    v-if="item.type === 'error'"
                                />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p
                                    class="text-sm font-medium text-gray-900 dark:text-white"
                                    v-if="item.type === 'success'"
                                >
                                    Successfully!
                                </p>

                                <p
                                    class="text-sm font-medium text-gray-900 dark:text-white"
                                    v-if="item.type === 'error'"
                                >
                                    Error!
                                </p>
                                <p
                                    class="mt-1 text-sm text-gray-500 dark:text-gray-400"
                                    v-html="item.message"
                                ></p>
                            </div>
                            <div class="ml-4 flex shrink-0">
                                <button
                                    type="button"
                                    @click="removeNotify(item.id)"
                                    class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600 dark:hover:text-white dark:focus:outline-indigo-500"
                                >
                                    <span class="sr-only">Close</span>
                                    <XMarkIcon
                                        class="size-5"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </div>
                        <div class="h-1 w-full bg-gray-100 mt-3 rounded-b-md">
                            <div
                                class="progress-bar h-full bg-blue-500 rounded-b-md"
                                :style="{
                                    animation: `shrink 10000ms linear forwards`,
                                }"
                                @animationend="removeNotify(item.id)"
                            ></div>
                        </div>
                    </div>
                </div>
            </transition-group>
        </div>
    </div>
</template>

<style>
@keyframes shrink {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}
</style>

<style scoped>
.toast-card:hover .progress-bar {
    animation-play-state: paused !important;
}
</style>
