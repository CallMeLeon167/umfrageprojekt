<template>
    <div class="home__wrapper">
        <div class="home__left">
            <h2>Letzte Umfrage</h2>
            <div class="last__survey">
                <h3>Umfrage Title</h3>
                <p>Das ist die letzte Umfrage</p>
            </div>
        </div>
        <div class="home__right">

        </div>
    </div>
</template>

<script setup lang="ts">

</script>

<style scoped>
    .home__wrapper {
        display: flex;
        flex-wrap: wrap;
    }

    .home__left {
        width: 70%;
    }

    .home__right {
        width: 30%;
    }

    .last__survey{
        padding: 20px;
        border-radius: 7px;
        border: 2px solid var(--border);
    }
    .last__survey h3,
    .last__survey p {
        margin: 0;
    }

    @media (max-width: 768px) {
        .home__left,
        .home__right {
            width: 100%;
        }
    }
</style>
