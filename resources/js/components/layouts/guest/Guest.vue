<template>
    <div>
        <guest-header></guest-header>
        <slot />
    </div>
</template>

<script>
    import GuestHeader from "./Header.vue"
    export default {
        components : {
            GuestHeader
        }
    }
</script>