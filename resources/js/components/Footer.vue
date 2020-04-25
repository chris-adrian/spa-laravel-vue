<template>
  <footer class="text-center mt-5">
    <p>
      Created with passion and a bit of haste by <router-link to="/author">Chris</router-link>,<br/>
      For the purpose of applying and hopefuly securing a web developer position.
    </p>
  </footer>
</template>

<script>
export default {
    name:'pageFooter',
    components: {

    }
}
</script>

<style>
  footer {
    /* background: #404040; */
    background: #1f1f1f;
    color: #fff;
  }
  footer p {
    margin: 0px;
    padding: 15px;
  }
  footer p a {
    color: #fff;
    font-weight: bold;
  }
</style>