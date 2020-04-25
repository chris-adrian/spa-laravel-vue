<template>
<div class="card">
  <div class="card-header">
    Create a post
    <alerts :alerts="notifs" for="message"/>
  </div>
  <div class="card-body">
    <form type="post" @submit.prevent="submit">
      <div class="form-group row justify-content-center">
        <label class="col-md-2 col-form-label text-md-right" for="title">Title</label>
        <div class="col-md-6">
          <input class="form-control" name="title" type="text" v-model="form.title">
          <alerts :alerts="notifs" for="title"/>
        </div>
      </div>

      <div class="form-group row justify-content-center">
        <label class="col-md-2 col-form-label text-md-right" for="description">Description</label>
        <div class="col-md-6">
          <textarea class="form-control" name="description" v-model="form.description"></textarea>
          <alerts :alerts="notifs" for="description"/>
        </div>
      </div>
      
      <div class="form-group row justify-content-center">
        <label class="col-md-2 col-form-label text-md-right" for="image">image</label>
        <div class="col-md-6">
          <input type="file" v-if="inputReady" @change="imageSelect" name='image'>
          <alerts :alerts="notifs" for="image"/>
        </div>
      </div>

      <div class="text-center">
        <button class="btn btn-primary" :disabled="inputSubmitBtn" type="submit">Post</button>
      </div>
    </form>
  </div>
</div>
  
</template>

<script>
import alerts from '../components/Alerts'

export default {
  name: 'PostForm',
  components: {
    alerts
  },
  data() { 
    return {
      form: {
        title: '',
        description: '',
        image: ''
      },
      notifs: {
        success: {},
        danger:{},
        primary:{}
      },
      inputReady: true,
      inputSubmitBtn: false
    }
  },
  methods: {
      imageSelect(event) {
        this.form.image = event.target.files[0]
      },
      convertSize(val1, val2, ext) {
          // return Math.round(val1*val2)
          ext = ext ? ' '+ext : ''
          return (val1*val2).toFixed(2)+ext
      },
      submit() {
        this.resetNotif();

        if(this.validate()) {
          this.inputSubmitBtn = true;
          const fd = new FormData();      
          fd.append('title', this.form.title)
          
          if(this.form.description) {
            fd.append('description', this.form.description)
          }  
          if(this.form.image) {
            fd.append('image', this.form.image, this.form.image.name)
          }
          
          axios.post('post/create', fd, {
              onUploadProgress : uploadEvent => {
                if(this.form.image) {
                  console.log('upload progress : ' + Math.round(uploadEvent.loaded / uploadEvent.total * 100) + '%')
                }
              }
          })
          .then((res)=> {
              // response = res.data;
              // console.log(res)
              this.resetForm();
              this.$set(this.notifs,'success', res.data)
              this.$emit('new-post')
              this.inputSubmitBtn = false;
          })
          .catch((err)=> {
              this.$set(this.notifs, 'danger', err.response.data.errors);
              this.inputSubmitBtn = false;
          });

        }
      },
      validate() {
        let validation = true;
        let fileTypes = ['jpeg', 'png']
        let uploadLimit = 500000 
        let vm = this;
        
        if(!vm.form.title) {
            vm.$set(vm.notifs.danger, 'title', 'Please provide a title' )
            validation = false
        } else {
          if(vm.form.title.length > 100 ) {
              vm.$set(vm.notifs.danger, 'title', 'Exceeded character limit (max 100)' )
              validation = false
          }
          if(!(vm.form.image || vm.form.image || vm.form.description)) {
              vm.$set(vm.notifs.danger, 'image', 'Please provide either an image or description' )
              vm.$set(vm.notifs.danger, 'description', 'Please provide either an image or description' )
              validation = false
          } 
          if(vm.form.image) {
              let imageType = vm.form.image.type.split("/");
              let typeValid = false;
              fileTypes.forEach(t => {
                  if(t == imageType[1]) {
                      typeValid = true;
                  } 
              });
              if(!typeValid) {
                  vm.$set(vm.notifs.danger, 'image', 'File type is invalid, only images(JPG, PNG) are allowed')
                  validation = false
              }1
              if(vm.form.image.size > uploadLimit) {
                  vm.$set(vm.notifs.danger, 'image', 'Image exceeds upload limit of '+vm.convertSize(uploadLimit,.00001, 'MB')+', current : '+ vm.convertSize(vm.form.image.size,.00001, 'MB'))
                  validation = false
              }
          }
        }
        return validation
      },
      resetForm() {
        this.form.title = "";
        this.form.description = "";
        this.form.image="";
        this.inputReady = false
        this.$nextTick(() => {
          this.inputReady = true
        })
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
      }
  }
}
</script>

<style scoped>
  form button[type="submit"]{
    width: 100%;
    max-width: 250px;
    text-transform: uppercase;
  }
  form input[type="file"] {
    width: 100%;
    border-bottom: solid 1px #e0e0e0;
  }
  form label {
    text-transform: uppercase;
  }
</style>