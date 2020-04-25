<template>
  <div class="card">
    <div class="card-header heading">
      <div class="row">
        <div class="col-md-6 text-left">
          <h1>{{ fullName }}</h1>
          <alerts :alerts="notifs" for="message"/>
        </div>

        <div class="col-md-6 text-right">
          <button v-if="this.$store.state.user.authorization == 2" @click="toggle()" type="button" class="btn">
            <svg v-if="!edit" class="bi bi-pencil-square" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z" clip-rule="evenodd"/>
            </svg>
            <svg v-else class="bi bi-check" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div class="card-body content">
      <div class="row">
        <!-- Left Column -->
        <div class="col-md-4">    
          <!-- IMAGE ROW -->
          <div class="row">
            <div class="col-md-12">
              <div class="image-wrapper">
                <img :src="this.profileImageLink">
                <form v-if="this.$store.state.user.authorization == 2" >
                  <input class="d-none" type="file" ref="imageFile" v-if="inputReady" @change="profileSelect" name='image'>
                  <alerts :alerts="notifs" for="image"/>
                  <div class="overlay" @click="$refs.imageFile.click()">
                    <svg class="bi bi-card-image" viewBox="0 0 16 16" fill="currentColor">
                      <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5zm-13-1A1.5 1.5 0 000 3.5v9A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0014.5 2h-13z" clip-rule="evenodd"/>
                      <path d="M10.648 7.646a.5.5 0 01.577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 01.63-.062l2.66 1.773 3.71-3.71z"/>
                      <path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"/>
                    </svg>
                    <span>Update Image</span>
                  </div>
                  <small class="text-black d-none d-sm-block d-md-none mb-2">Click on the image to update</small>
                </form>
              </div>
            </div>
          </div>
          <!-- More contents -->
        </div>      
        <!-- Right Column -->
        <div v-if="edit" class="col-md-8">
          <form type="post" @submit.prevent="submit">
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="first_name">First Name</label>
              <div class="col-md-5">
                <input class="form-control" name="first_name" type="text" v-model="form.first_name">
                <alerts :alerts="notifs" for="first_name"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="middle_name">Middle Name</label>
              <div class="col-md-5">
                <input class="form-control" name="middle_name" type="text" v-model="form.middle_name">
                <alerts :alerts="notifs" for="middle_name"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="last_name">Last Name</label>
              <div class="col-md-5">
                <input class="form-control" name="last_name" type="text" v-model="form.last_name">
                <alerts :alerts="notifs" for="last_name"/>
              </div>
            </div>
            <hr/>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="memo">Introduction</label>
              <div class="col-md-5">
                <textarea class="form-control" name="memo" v-model="form.memo"></textarea>
                <alerts :alerts="notifs" for="memo"/>
              </div>
            </div>
            <hr/>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="classification">Classification</label>
              <div class="col-md-5">
                <!-- <input class="form-control" name="classification" type="text" v-model="form.classification"> -->
                <select  class="form-control" name="classification" v-model="form.classification">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Rather not say">Rather not say</option>
                </select>
                <alerts :alerts="notifs" for="classification"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="occupation">Occupation</label>
              <div class="col-md-5">
                <input class="form-control" name="occupation" type="text" v-model="form.occupation">
                <alerts :alerts="notifs" for="occupation"/>
              </div>
            </div>
            <hr/>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="dob">Date of Birth</label>
              <div class="col-md-5">
                <!-- <input class="form-control" name="dob" type="text" v-model="form.dob"> -->
                <!-- <Calendar></Calendar> -->
                <vc-date-picker 
                  :mode="'single'" 
                  :max-date="new Date()" 
                  locale="dob-locale" 
                  :input-props='{
                    class: "form-control",
                    name:"dob",
                    placeholder: form.dob,
                    readonly: true
                  }'
                  v-model="form.dob" /> 
                <alerts :alerts="notifs" for="dob"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="address">Address</label>
              <div class="col-md-5">
                <input class="form-control" name="address" type="text" v-model="form.address">
                <alerts :alerts="notifs" for="address"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="nationality">Nationality</label>
              <div class="col-md-5">
                <input class="form-control" name="nationality" type="text" v-model="form.nationality">
                <alerts :alerts="notifs" for="nationality"/>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-md-2 col-form-label text-md-right" for="religion">Religon</label>
              <div class="col-md-5">
                <input class="form-control" name="religion" type="text" v-model="form.religion">
                <alerts :alerts="notifs" for="religion"/>
              </div>
            </div>
          </form>
        </div>
        <div v-else class="col-md-8">
          <!-- General Info -->
          <div class="row card">
            <div class="col-md-12 card-header">
              <h2>Introduction</h2>
            </div>
            <div class="col-md-12 card-body">
              <blockquote>
                {{ form.memo ? form.memo : 'Have yet to compose...' }}
              </blockquote>
            </div>
          </div>
          <div class="row card">
            <div class="col-md-12 card-header">
              <h2>General</h2>
            </div>
            <div class="col-md-12 card-body">
              <ul>
                <!-- <li>{{ form.first_name+" "+form.last_name }}</li> -->
                <li>Classification : {{ form.classification ? form.classification : '...' }}</li>
                <li>Occupation : {{ form.occupation ? form.occupation : '...' }}</li>
                <!-- <li>Introduction : {{ form.memo }} </li> -->
              </ul>
            </div>
          </div>
          <!-- Personal Info -->
          <div v-if="this.$store.state.user.profileExtension" class="row card">
            <div class="col-md-12 card-header">
              <h2>Personal</h2>
            </div>
            <div class="col-md-12 card-body">
              <ul>
                <li>Date of Birth : {{ form.dob ? form.dob : '...' }}</li>
                <li>Address : {{ form.address ? form.address : '...' }}</li>
                <li>Nationality : {{ form.nationality ? form.nationality : '...' }}</li>
                <li>Religion : {{ form.religion ? form.religion : '...' }} </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
      
    <modal v-on:modal-action="modalAction" :type="modal.type" :title="modal.title" :body="modal.body"/>
    <loader v-if="!pageReady" />
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import alerts from '../components/Alerts'
import modal from '../components/Modal'
import loader from '../components/Loader'
const moment = require('moment');

export default {
    name: 'profile',
    components: {
      alerts,
      modal,
      loader
    },
    data() {
      return {
        form: {
          first_name: '',
          middle_name: '',
          last_name: '',
          classification: '',
          occupation: '',
          memo: '',
          image: '',
          dob: '',
          address: '',
          nationality: '',
          religion: '',
        },
        notifs: {
          success:{},
          danger:{},
          primary:{}
        },
        modal: {
          type: '',
          title: '',
          body: ''
        },
        edit: false,
        profileImage : undefined,
        profileImageLink: undefined,
        inputReady: true,
        contentReady: false
      }
    },
    head: {
      title: function () {
        return {
          inner: this.$store.state.auth.user.fullname.last_name
        }
      },
      meta: [
        { name: 'description', content: 'Account Profile'}
      ]
    },
    computed:{ 
      fullName: function() {
        let middle = this.form.middle_name ? ' '+this.form.middle_name+' ' : ' '
        let fName = this.form.first_name+middle+this.form.last_name
        return fName;
      },
      pageReady: function() {
        return this.contentReady;
      },
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
        getInfo: 'user/getInfo',
        updateProfile: 'user/updateProfile',
        updateImage: 'user/updateProfileImage'
      }),
      formNameLink() {
        let tempMiddle = this.form.middle_name ? '.'+this.form.middle_name+'.' : '.'
        let tempFname = this.form.first_name+tempMiddle+this.form.last_name
        return tempFname.replace(/\s+/g, '-').toLowerCase()
      },
      toggle() {
        if(this.edit){
          if(this.validate()){
            this.submit();    
          }
        } else {
          this.edit = !this.edit;
        }
      },
      submit(){
        this.resetNotif()
        // console.log(this.formNameLink())
        //Format Date picker output before update
        this.form.dob = this.form.dob ? moment(this.form.dob).format('YYYY-MM-DD') :  moment(new Date()).format('YYYY-MM-DD') 
        
        this.updateProfile(this.form)
        .then((res)=>{
          // console.log(this.formNameLink())
          this.$router.replace(this.formNameLink())
          
          // this.getProfile(this.formNameLink());
          this.edit = !this.edit;
        })
        .catch((err)=>{
          this.$set(this.notifs, 'danger', err.errors);
        })
      },
      validate() {
        let form = this.form
        let valid = true;
        if (!form.first_name) {
          this.$set(this.notifs.danger, 'first_name', 'First name is required');
          valid = false;
        }
        if (!form.last_name) {
          this.$set(this.notifs.danger, 'last_name', 'Last name is required');
          valid = false;
        }
        return valid;
      },
      modalAction(action) {
        switch (action) {
          case 'upload':
            this.upload();
            break;
          case 'cancel':
          default:
            console.log('No action(s) made')
            //Reset Modified Inputs (File types)
            this.inputReady = false
            this.$nextTick(() => {
              this.inputReady = true
            })
            break;
        }
      },
      upload(){
        // console.log('uploading...')
        const fd = new FormData();      
        fd.append('image', this.form.image, this.form.image.name)

        this.updateImage(fd)
        .then((res)=> {
          this.getProfile();
        })
        .catch((err)=> {
          this.$set(this.notifs, 'danger', err.errors);
        }); 
      },
      initProfile() {
        let myForm = this.form;
        let stateProfile = this.$store.state.user.profile;
        let stateProfileExt = this.$store.state.user.profileExtension;

        // Reset Form Data 
        for(let mFindex in myForm) { 
          myForm[mFindex] = ''
        }
        // Profile Info
        for(let sPindex in stateProfile) {
          for(let mFindex in myForm) {
            if(sPindex == mFindex){
              if(stateProfile[sPindex]) {
                myForm[mFindex] = stateProfile[sPindex];
              } else {

                if(mFindex == 'middle_name' || mFindex == 'image') {
                  myForm[mFindex] = ''
                } else {
                  myForm[mFindex] = ''
                }
                
              }
            }
          }
        }
        // Profile Info
        if(stateProfileExt){
          for(let sPindex in stateProfileExt) {
            for(let mFindex in myForm) {
              if(sPindex == mFindex){
                if(stateProfileExt[sPindex]) {
                  // if(sPindex == 'dob') {
                  //   myForm[mFindex] = new Date(stateProfileExt[sPindex])
                  // } else {
                    myForm[mFindex] = stateProfileExt[sPindex];
                  // }
                } else {
                  if(sPindex == 'dob') {
                    myForm[mFindex] = moment(new Date()).format('YYYY-MM-DD')+' (Date Account Registered)'
                  } else {
                    myForm[mFindex] = ''
                  }
                }
              }
            }
          }
        }
        // Hold Profile Image
        this.profileImage = this.form.image;
        this.setImageLink()
        this.contentReady = true;
      },
      getProfile(namelink) {
        this.contentReady = false;
        //Get path name
        let fullName;
        if(namelink) {
          fullName = namelink;
        } else {
          fullName = this.$route.params.fullname;
        }
        fullName = fullName.split('.')

        //Remove dashes
        for (let i = 0; i < fullName.length; i++) {
            fullName[i] = fullName[i].replace(/-/g," ");
        }
        
        
        switch (fullName.length) {
          case 2: 
            this.getInfo({
                first_name: fullName[0],
                last_name: fullName[fullName.length-1]
            })
            .then(()=>{
              this.initProfile();
            })
            .catch(()=>{
              this.$router.replace('/404')
            })
            break;
          case 3:
            this.getInfo({
                first_name: fullName[0],
                middle_name: fullName[1],
                last_name: fullName[fullName.length-1]
            })
            .then(()=>{
              this.initProfile();
            })
            .catch(()=>{
              this.$router.replace('/404')
            })
            break;
          case 1:
          default:
            // this.$router.replace({
            //     name: 'notfound'
            // })
            break;
        }
      },
      resetNotif(){
        let myNotif = this.notifs;
        for(let oField in myNotif) {
          for(let iField in myNotif[oField]) {
              if(myNotif[oField][iField]) {
              myNotif[oField][iField] = undefined;
              }
          }
        }
      },
      profileSelect(event) {
        this.form.image = event.target.files[0]
        this.modal.type = 'upload'
        this.modal.title = 'Update Profile Image?'
        this.modal.body = 'This will replace the current profile image'
        $('#globalModal').modal('toggle')
      },
      setImageLink(){ 
        let myImage = this.profileImage;
        if(myImage == null || myImage == '') {
          myImage = 'profiles/default-img.png'  
        }
        this.profileImageLink = '/storage/'+myImage+'?r='+this.rndStr(5)
      },
      rndStr(len) {
        let text = ""
        let chars = "abcdefghijklmnopqrstuvwxyz"
      
        for( let i=0; i < len; i++ ) {
          text += chars.charAt(Math.floor(Math.random() * chars.length))
        }
        return text
      }
    },
    watch: {
      '$route': function(to, from) {
        this.getProfile();
      }
    },
    created: function() {
      this.getProfile();
      this.initProfile();
    }
}
</script>

<style scoped>
  .card h1 {
    font-size: 150%;
    line-height: 160%;
  }
  .card h2 {
    font-size: 120%;
    margin: 0px;
  }
  .card-body blockquote {
    padding: 15px;
    border-left: solid 2px #e4e4e4;
    font-style: italic;
  }
  .card-body .card-header {
    padding: 8px;
    text-indent: 5px;
  }
  .card ul, .card ol {
    margin: 0px;
    padding: 0px;
    list-style-type: none;
  }
  .card ul li, .card ol li { 
    font-size: 115%;
    margin-bottom: 5px;
  }
  .btn {
    width: 2.5em;
    height: 2.5em;
    padding: 5px;
    color: #fff;
  }
  .image-wrapper {
    position: relative;
    text-align: center;
  }
  .image-wrapper img {
    max-width: 450px;
    width: 100%;
    height: auto;
    border-radius: 14px;
  }
  .image-wrapper .overlay {
    border-radius: 14px;
    display: none;
    position: absolute;
    margin-left: auto;
    margin-right: auto;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    max-width: 450px;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    color: #fff;
  }
  .image-wrapper .overlay svg { 
    width: 15%;
    height: 15%;
    position: absolute;
    margin-right: auto;
    margin-left: auto;
    left: 0;
    right: 0;
    bottom: 0;
  }
  .image-wrapper:hover .overlay { 
    display: inherit;
  }
</style>