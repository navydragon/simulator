<template>
  <div>
    <component :is="layout">
        <router-view></router-view>
    </component>
  </div>
</template>


<script>
  const default_layout = "user"
  export default {
    computed: {
      layout() {
        return (this.$route.meta.layout || default_layout) + '-layout';
      }
    },
  }  
</script>