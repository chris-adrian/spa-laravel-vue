<template>
  <div class="row">
    <div class="col-md-12">
      <h1>About</h1>
      <blockquote>
        This APP is inteded for application purposes only by the author, 
        created with a limited scope and hastily put together while learning the necessary knowledge about the technology that encompasses this application.
        <hr/>
        Source / Technology Stack :
        <ul>
          <li><a href="https://laravel.com/">Laravel Framework (PHP)</a> 
            <ul>
              <li><a href="http://image.intervention.io/">Intervention Image</a></li>
              <li><a href="https://jwt-auth.readthedocs.io/en/develop/">JW-auth</a></li>
            </ul>
          </li>
          <li><a href="https://vuejs.org/">Vue Framework (JS)</a>
            <ul>
              <li><a href="https://router.vuejs.org/">Vue-Router</a></li>
              <li><a href="https://vuex.vuejs.org/">Vuex</a></li>
              <li><a href="https://github.com/ktquez/vue-head">Vue-head</a></li>
            </ul>
          </li>
          <li><a href="https://jquery.com/">jQuery (JS)</a></li>
          <li><a href="https://github.com/axios/axios">Axios (HTTP)</a></li>
          <li><a href="https://getbootstrap.com/">Twitter bootstrap (CSS)</a>
            <ul>
              <li><a href="https://icons.getbootstrap.com/">Bootstrap Icons</a></li>
            </ul>
          </li>
          <li><a href="https://www.transparenttextures.com/">Transparent Textures</a></li>
        </ul>
      </blockquote>
      <h2 class="mt-5">Disclaimer</h2>
      <p>
        The information or materials provided by the author on this app is intended for Job application purposes only.<br/>
        All Sources on the site is delivered in good faith, however the author makes no representation or warranty of any kind, express or implied,
        regarding the accuracy, adequacy, validity, reliability, availability or completeness of any information on the app.<br/>
        <br/>
        All Source or materials used are credited to their respective owners, if an issue do so arises, please kindly contact the author.   
      </p>
    </div>
    <div class="col-md-12">
      <author />
    </div>
  </div>
</template>

<script>
import author from '../components/Author'

export default {
  name: 'about',
  components: {
    author
  }
}
</script>

<style>

</style>