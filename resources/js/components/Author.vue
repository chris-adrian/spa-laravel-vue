<template>
  <div class="container author mt-5 mb-5">
      <div class="row pt-5 pb-5 justify-content-center">
          <div class="col-md-3 mb-4 text-center">
              <img src="/images/author.jpg" alt="">
          </div>
          <div class="col-md-5">
              <h3>
                  <a href="">Chris James Adrian C. Peñas</a>
                  <hr/>
                  <small>Author / Full Stack Web Developer</small>
              </h3>
              <blockquote>
                    <b>Chris</b> is a passionate web developer, with almost 3 years in total experience of developing with PHP, Javascript, Bootstrap and 
                    E-Commerce related platforms (Prestashop, Shopify).<br/>
                    Currently studying Japanese Language (日本語) in japan and has started self studying Laravel and Vue frameworks and soon React. 
                    <ul>
                        <li>
                            Github Account : <a href="https://github.com/chris-adrian" target="_blank">github.com/chris-adrian</a>
                        </li>
                    </ul>
              </blockquote>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    name: 'author',
    head: {
      title: function () {
        return {
          inner: 'Author'
        }
      },
      meta: [
        { name: 'description', content: 'Web Author'}
      ]
    }
}
</script>

<style scoped>
    .author img {
        width: 100%;
        max-width: 200px;
        height: auto;
    }
    .author hr {
        margin: 0px;
    }
    .author h3 a {
        text-decoration: none;
        color : #000;
    }
    .author h3 small {
        font-size: 50%;
        font-weight: bold;
        /* font-style: italic; */
    }
    .author blockquote {
        padding: 15px;
        border-left: solid 2px #e4e4e4;
    }
    .author ul {
        list-style-type: none;
        padding: 0px;
        margin-top: 1em;
    }
</style>