<template>
<header>
  <!-- Navbar -->
    <nav-bar></nav-bar>
  <!-- Navbar -->

    

  <!-- Jumbotron -->
  <div class="text-center bg-gray-50 text-gray-800 py-10 px-6">
    <h1 class="text-5xl font-bold mt-0 mb-6">Тренажер</h1>
    <h3 class="text-3xl font-bold ">по SQL</h3>
    
  </div>
  <!-- Jumbotron -->
</header>
</template>

<script>
    import NavBar from "./NavBar.vue"
    export default {
        components : {
            NavBar
        }
    }
</script>