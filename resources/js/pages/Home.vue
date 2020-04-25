<template>
  <Welcome v-if="!logged" />
  <PostList v-else :allEntries="true" />
</template>

<script>
import PostList from '../components/PostList'
import Welcome from '../components/Welcome'

export default {
    name: 'home',
    components: {
      PostList,
      Welcome
    },
    computed: {
      logged: function() {
        let rVal = false;
        if(this.$store.state.auth.user !== null) {
          rVal = true;
        }
        return rVal;
      }
    }
}
</script>

<style>

</style>