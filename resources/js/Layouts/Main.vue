<script setup>
import Sidebar from "@/Components/Sidebar.vue";
import Toast from "@/Components/Toast.vue";
</script>

<template>
    <Toast />
    <Sidebar>
        <slot></slot>
    </Sidebar>
</template>

<style scoped></style>
