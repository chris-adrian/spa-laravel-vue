<template>
  <div id="page">
    <div :class="this.$route.name == 'home' ? 'main' : 'container mt-5'" >
      <transition name="view">
        <router-view></router-view>    
      </transition>
    </div>
  </div>
</template>

<script>
export default {
    Name: 'page',
    components: {
    }
}
</script>
<style>
  #page {
    min-height: 600px;
    min-height: calc(100vh - 200px);
  }
  #route-home.user #page .main {
    margin-top: 3em;
  }
</style>