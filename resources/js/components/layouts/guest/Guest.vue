<template>
    <div>
        <guest-header></guest-header>
        <slot />
    </div>
</template>

<script>
    import GuestHeader from "./Header.vue"
    export default {
        inject: ['user'],
        components : {
            GuestHeader
        },
        created() {
            if (this.user !== "")
            {
                this.$router.push('/home')
            }
        }
    }
</script>