<template>
  <div class="card">
    <div class="card-header text-center">
      <h1>Account Update</h1>
      {{ notifs }}
      <alerts v-if="mErrDisp" :alerts="notifs" for="message|messages"/>
    </div>
    <div class="card-body">
      <form type="post" @submit.prevent="submit">
        <div class="form-group row justify-content-center">
          <label class="col-md-2 col-form-label text-md-right" for="username">Username</label>
          <div class="col-md-4">
            <input class="form-control" name="username" type="text" v-model="form.username">
            <alerts :alerts="notifs" for="username"/>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label class="col-md-2 col-form-label text-md-right" for="email">Email</label>
          <div class="col-md-4">
            <input class="form-control" name="email" type="email" v-model="form.email">
            <alerts :alerts="notifs" for="email"/>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label class="col-md-2 col-form-label text-md-right" for="password">Password</label>
          <div class="col-md-4">
            <input class="form-control" name="password" type="password" v-model="form.password">
            <alerts :alerts="notifs" for="password"/>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label class="col-md-2 col-form-label text-md-right" for="newPassword">New Password</label>
          <div class="col-md-4">
            <input class="form-control" name="newPassword" type="password" v-model="form.newPassword">
            <alerts :alerts="notifs" for="newPassword"/>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label class="col-md-2 col-form-label text-md-right" for="confirmPassword">Confirm Password</label>
          <div class="col-md-4">
            <input class="form-control" name="confirmPassword" type="password" v-model="form.confirmPassword">
            <alerts :alerts="notifs" for="confirmPassword|newPassword"/>
          </div>
        </div>
        <div class="text-center">
          <button class="btn btn-primary w-25" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import alerts from '../components/Alerts'

export default {
    name: 'account',
    components: {
      alerts
    },
    data() { 
      return {
        form: {
          username: '',
          email: '',
          password: '',
          newPassword: '',
          confirmPassword: '',
        },
        notifs: {
          success: {},
          danger:{},
          primary:{}
        },
        user_acc:{},
        mErrDisp: true
      }
    },
    head: {
      title: {
        inner: 'Account'
      },
      meta: [
        { name: 'description', content: 'Update account information', id: 'desc' }
      ]
    },
    computed: {
      modified: function() {
        // let myForm = _.cloneDeep(this.form)
        // this.$delete(myForm, 'username')
        let mods = 0;

        if (this.form.username !== this.user_acc.username) {
          mods++;
        }
        if (this.form.email !== this.user_acc.email) {
          mods++;
        } 
        if (this.form.newPassword) {
          mods++;
        } 
        mods = mods > 0 ?  true : false;
        return mods;
      }
    },
    methods: {
        ...mapActions({
          update: 'user/updateAccount',
          account: 'user/account',
          verify: 'auth/signIn'
        }),
        submit() {  
          this.resetNotif();
          if (this.modified) {
            if (this.validate()) {
              this.verify({
                //Account Check
                username: this.user_acc.username,
                password: this.form.password,
                check: true
              })
              .then(()=> {
                //Account Update
                this.update(this.form)
                .then((res)=> {
                  //Reset
                  this.$set(this.notifs.success, 'message', res.data.message);
                  this.resetForm();
                  this.loadData();
                  // this.resetNotif();
                  // console.log(res);
                  // this.$router.go(0);
                })
                .catch((err)=> {
                  // this.notifs = err;
                  console.log('update attempt : '+ err.errors)
                  this.$set(this.notifs, 'danger', err.errors);
                });  
              })
              .catch((err)=> {
                // this.notifs = err;
                // console.log(err.errors.message)
                this.$set(this.notifs, 'danger', err.errors);
                // this.$set(this.notifs.danger, 'messages', [err.errors.message]);
              });
            }
          } else {
            this.$set(this.notifs.primary, 'message','No changes to commit');
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
          if (!form.password) {
            this.$set(this.notifs.danger, 'password', 'Password is required');
            valid = false;
          }
          if ((form.newPassword || form.confirmPassword) && form.newPassword !== form.confirmPassword) {
            this.$set(this.notifs.danger, 'message', 'Password confirmation doesn\'t match');
            valid = false;
          }
      
          return valid;
        },
        loadData(){
          this.account()
          .then((res)=>{
            this.user_acc = res;
            this.form.username = res.username;
            this.form.email = res.email;
          })
          .catch((err)=>{
            console.log(err);
          });
        },
        resetForm(){
          let tForm = this.form;
          this.errors = {};

          tForm.username ='';
          tForm.email ='';
          tForm.password ='';
          tForm.newPassword ='';
          tForm.confirmPassword ='';
        },
        resetNotif(){
          this.mErrDisp = false
          
          let myNotif = this.notifs;
          for(let oField in myNotif) {
            for(let iField in myNotif[oField]) {
               if(myNotif[oField][iField]) {
                myNotif[oField][iField] = undefined;
               }
            }
          }

          this.$nextTick(() => {
              this.mErrDisp = true
          })
        }
      },
      created: function () {

        this.loadData();

      }
}
</script>

<style>

</style>