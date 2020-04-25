<template>
  <div class="card">
    <div class="card-header text-center">
      <h1>Account Signin</h1>
      {{ notifs }}
      <alerts :alerts="notifs" for="message"/>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <p>
            Please login with the account you have registered,<br/>
            If you haven't, create one <router-link to="/register">here</router-link>.<br/>
            <br/>
            Don't forget to logout when you are done.
          </p>          
        </div>
        <div class="col-md-8">
          <form type="post" @submit.prevent="submit">
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="username">Username</label>
              <div class="col-md-5">
                <input class="form-control" name="username" type="text" v-model="form.username">
                <alerts :alerts="notifs" for="username"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="password">Password</label>
              <div class="col-md-5">
                <input class="form-control" name="password" type="password" v-model="form.password">
                <alerts :alerts="notifs" for="password"/>
              </div>
            </div>
            <div class="text-center justify-content-center">
              <button class="btn btn-primary w-25" type="submit">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import alerts from '../components/Alerts'

  export default {
      name: 'signin',
      components: {
        alerts
      },
      data() {
        return {
          form: { 
            username: '',
            password: '', 
          },
          notifs: {
            success: {},
            danger:{},
            primary:{}
          }
        }
      },
      head: {
        title: {
          inner: 'Login'
        },
        meta: [
          { name: 'description', content: 'Sign in credentials', id: 'desc' }
        ]
      },
      methods: {
        ...mapActions({
          signIn: 'auth/signIn'
        }),
        submit() {  
          this.resetNotif();
          if (this.validate()) {
            this.signIn(this.form).then((res)=> {
              this.$router.replace('/')
            })
            .catch((err)=> {
              this.$set(this.notifs, 'danger', err.errors);
            });
          }
        },
        validate() {
          let form = this.form
          let valid = true;

          if (!form.username) {
            this.$set(this.notifs.danger, 'username', 'Username is required');
            valid = false;
          }
          if (!form.password) {
            this.$set(this.notifs.danger, 'password', 'Password is required');
            valid = false;
          }
          return valid;
        },
        resetNotif(){
          let myNotif = this.notifs;
          for(let oField in myNotif) {
            for(let iField in myNotif[oField]) {
              myNotif[oField][iField] = undefined;
            }
          }
        }
      }, 
      created: function() {
      }
  }
</script>

<style>
  
</style>