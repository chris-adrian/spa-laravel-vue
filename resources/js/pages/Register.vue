<template>
  <div class="card">
    <div class="card-header text-center">
      <h1>Account Register</h1>
      <alerts :alerts="notifs" for="message"/>
      <!-- {{ form }} -->
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <p>
            Please fill all the necessary information to create your account.<br/>
            <br/>
            <b>Notes :</b>
            <ul>
              <li>Username and Password :
                <ul>
                  <li>Only accepts characters from A ~ Z and 0 ~ 9</li>
                  <li>Spaces and other characters are not allowed</li>
                </ul>
              </li>
              <li>Email :
                <ul>
                  <li>Please use a valid email address for features later on</li>
                </ul>
              </li>
              <li>Name :
                <ul>
                  <li>Must be unique</li>
                  <li>A middle name is required if the first and last names are already taken</li>
                </ul>
              </li>
            </ul>
          </p>  
        </div>
        <div class="col-md-8">
          <form type="post" @submit.prevent="submit">
            <div class="form-group row justify-content-center">
              <label class="col-md-3 col-form-label text-md-right" for="username">Username</label>
              <div class="col-md-6">
                <input class="form-control" name="username" type="text" v-on:keyup="format('username', true)" v-model="form.username">
                <alerts :alerts="notifs" for="username" placeholder="( Alpha and numerical characters only )"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-3 col-form-label text-md-right" for="email">Email</label>
              <div class="col-md-6">
                <input class="form-control" name="email" type="email" v-model="form.email">
                <alerts :alerts="notifs" for="email" placeholder="( Email.address@sample.com )"/>
              </div>
            </div>
            <div class="form-group row justify-content-center pt-4">
              <label class="col-md-3 col-form-label text-md-right" for="first_name">First Name</label>
              <div class="col-md-6">
                <input class="form-control" name="first_name" type="first_name"  v-on:keyup="format('first_name')"  v-model="form.first_name">
                <alerts :alerts="notifs" for="first_name"/>
              </div>
            </div>
            <!--  -->
            <div v-if="notifs.danger.middle_name || notifs.danger.full_name" class="form-group row justify-content-center">
              <label class="col-md-3 col-form-label text-md-right" for="middle_name">Middle Name</label>
              <div class="col-md-6">
                <input class="form-control" name="middle_name" type="middle_name" v-on:keyup="format('middle_name')"  v-model="form.middle_name">
                <alerts :alerts="notifs" for="middle_name"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-3 col-form-label text-md-right" for="last_name">Last Name</label>
              <div class="col-md-6">
                <input class="form-control" name="last_name" type="last_name" v-on:keyup="format('last_name')"  v-model="form.last_name">
                <alerts :alerts="notifs" for="last_name"/>
              </div>
            </div>
            <div class="form-group row justify-content-center pt-4">
              <label class="col-md-3 col-form-label text-md-right" for="password">Password</label>
              <div class="col-md-6">
                <input class="form-control" name="password" type="password" @input="format('password', true)" v-model="form.password">
                <alerts :alerts="notifs" for="password"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-3 col-form-label text-md-right" for="confirmPassword">Confirm Password</label>
              <div class="col-md-6">
                <input class="form-control" name="confirmPassword" type="password" @input="format('password', true)" v-model="form.confirmPassword">
                <alerts :alerts="notifs" for="confirmPassword|password"/>
              </div>
            </div>
            <div class="text-center">
              <button class="btn btn-primary w-25" type="submit">Sign Up</button>
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
          email: '',
          first_name: '',
          middle_name: '',
          last_name: '',
          password: '',
          confirmPassword: ''
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
        inner: 'Register'
      },
      meta: [
        { name: 'description', content: 'Account registration', id: 'desc' }
      ]
    },
    computed: {
      nameLink: function() {
        let myForm = _.cloneDeep(this.form), link;
        myForm.first_name = myForm.first_name.replace(/\s+/g, '-')
        myForm.last_name = myForm.last_name.replace(/\s+/g, '-')
        
        if(this.form.middle_name !== '') {
          myForm.middle_name = myForm.middle_name.replace(/\s+/g, '-')
          link = myForm.first_name+'.'+myForm.middle_name+'.'+myForm.last_name;
        } else {
          link = myForm.first_name+'.'+myForm.last_name;
        }
        return link.toLowerCase();
      }
    },
    methods: {
        ...mapActions({
          register: 'auth/register'
        }),
        format(model, acc = false) {
          let regEx = acc ? /[^0-9a-zA-Z]/g : /[^a-zA-Z\s]/g;
          this.form[model] = this.form[model].replace(regEx, '')
          // Remove excess whitespace
          this.form[model] = this.form[model].replace(/\s\s+/g,' ')
        },
        submit() {  
          // console.log(this.nameLink)
          this.resetNotif();
          if (this.validate()) {
            this.register(this.form).then(()=> {
              this.$router.replace(this.nameLink)
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
          if (!form.email) {
            this.$set(this.notifs.danger, 'email', 'Email is required');
            valid = false;
          }
          if (!form.first_name) {
            this.$set(this.notifs.danger, 'first_name', 'Firstname is required');
            valid = false;
          }
          if (!form.last_name) {
            this.$set(this.notifs.danger, 'last_name', 'Lastname is required');
            valid = false;
          }
          if (!form.password) {
            this.$set(this.notifs.danger, 'password', 'Password is required');
            valid = false;
          }
          if (!form.confirmPassword) {
            this.$set(this.notifs.danger, 'confirmPassword', 'Confirm password is required');
            valid = false;
          }
          if (form.password && form.confirmPassword) {
            if (form.password !== form.confirmPassword) {
              this.$set(this.notifs.danger, 'message', 'Password confirmation doesn\'t match');
              valid = false;
            }
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
      }
}
</script>

<style>

</style>