<template>
    <Header />
    <main>
        <slot></slot>
    </main>
</template>

<script setup lang="ts">
import Header from './header.vue';


</script>

<style scoped>
main{
    padding: 10px 30px;
}
</style>