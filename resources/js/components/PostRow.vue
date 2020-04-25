<template>
    <div :data-post-id="postData.id" class="row card mt-3">
        <div class="col-md-12 card-header">
            <div class="row">
                <div class="col-md-6 text-left">
                    <img :src="profile.image" alt="" class="responsive-thumbnail" />
                    <router-link :to="fullName(true)">{{ fullName() }}</router-link>
                </div>
                <div v-if="editable" class="col-md-6 text-right">
                    <button v-if="edit" @click="deletePost()" class="btn primary" type="button">
                        <svg class="bi bi-trash" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <button @click="toggle()" type="button" :class="'btn '+buttonClass">
                        <svg v-if="!edit" class="bi bi-pencil-square" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z" clip-rule="evenodd"/>
                        </svg>
                        <svg v-else class="bi bi-check" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"/>
                        </svg>
                        <!-- {{ edit ? 'Save' : 'Edit'}} -->
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12 card-body">
            <div class="row">
                <div :class="imageLink ? 'col-md-6' : 'col-md-12'">
                    <h3 v-if="!edit">{{ form.title }}</h3>
                    <div v-else class="form-group">
                        <input class="form-control" name="title" type="text" v-model="form.title">
                        <alerts :alerts="notifs" for="title"/>
                    </div>
                    <div v-if="!edit">
                        <p v-if="form.description">{{ form.description }}</p>
                    </div>
                    <div v-else class="form-group">
                        <textarea class="form-control" name="description" v-model="form.description"></textarea>
                        <alerts :alerts="notifs" for="description"/>
                    </div>
                    <div v-if="edit" class="form-group">
                        <input type="file" v-if="inputReady" @change="imageSelect" name='image'>
                        <alerts :alerts="notifs" for="image"/>
                    </div>
                </div>
                <div v-if="imageLink" class="col-md-6">
                    <div class="text-center image-wrapper">
                        <img :src="imageLink" alt="" class="responsive-image" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import alerts from '../components/Alerts'
import modal from '../components/Modal'

export default {
    name: 'PostRow',
    components: {
        alerts,
        modal
    },
    props: {
        rowIn: Number,
        pageIn: String,
        postData: Object,
        editable: Boolean
    },
    data() {
        return{
            form: {
                title: '',
                description: '',
                image: '',
                imageUpload: ''
            },
            notifs: {
                success: {},
                danger:{},
                primary:{}
            },
            profile: {
                image: ''
            },
            inputReady: true,
            edit: false
        }
    },
    computed: {
        buttonClass: function() {
            return this.edit ? 'success' : 'primary';
        },
        imageLink: function() {
            if(this.form.image) {
                return '/storage/'+this.form.image;
            }
            return false;
        }
    },
    methods: {
        fullName(isLink) {
            let data = this.postData;
            let joint = isLink ? '.' : ' '
            let middle = data.middle_name ? joint+data.middle_name+joint : joint
            let fName = data.first_name+middle+data.last_name
            return isLink ? fName.replace(/\s+/g, '-').toLowerCase() : fName
        },
        setProfileImage() {
            if(this.postData.p_image) {
                this.$set(this.profile, 'image', '/storage/profiles/thumbnails/'+this.postData.user_id+'-thumb.png')
            } else {
                this.$set(this.profile, 'image', '/storage/profiles/default-img.png')
            }
        },
        imageSelect(event) {
            this.form.imageUpload = event.target.files[0]
        },
        convertSize(val1, val2, ext) {
            ext = ext ? ' '+ext : ''
            return (val1*val2).toFixed(2)+ext
        },
        toggle() {
            if(this.edit){
                this.submit();    
            } else {
                this.edit = !this.edit;
            }
        },
        submit(){
            let vm = this;
            vm.resetNotif();

            if(this.validate()) {
                const fd = new FormData();      
                fd.append('title', vm.form.title)
                fd.append('description', vm.form.description)
                fd.append('id', vm.postData.id)

                if(vm.form.imageUpload) {
                    fd.append('image', vm.form.imageUpload, vm.form.imageUpload.name)
                }
                
                axios.post('post/update', fd, {
                    onUploadProgress : uploadEvent => {
                        if(vm.form.imageUpload) { 
                            console.log('upload progress : ' + Math.round(uploadEvent.loaded / uploadEvent.total * 100) + '%')
                        }
                    }
                })
                .then((res)=> {
                    vm.edit = !vm.edit;
                    if(res.data.image) {
                        vm.form.image = res.data.image
                    }
                })
                .catch((err)=> {
                    vm.$set(vm.notifs, 'danger', err.response.data.errors);
                });
            } 
        },
        validate() {
            let validation = true;
            let fileTypes = ['jpeg', 'png']
            let uploadLimit = 500000 
            let vm = this;
            
            if(vm.form.title == vm.postData.title && vm.form.description == vm.postData.description && vm.form.imageUpload == '') {
                // No changes made
                vm.edit = !vm.edit;
                validation = false
            } else {
                if(vm.form.title) {
                    if(vm.form.title.length > 100 ) {
                        vm.$set(vm.notifs.danger, 'title', 'Exceeded character limit (max 100)' )
                        validation = false
                    }
                } else {
                    vm.$set(vm.notifs.danger, 'title', 'A title must be provided' )
                    validation = false
                }
                if(!(vm.form.image || vm.form.imageUpload || vm.form.description)) {
                    vm.$set(vm.notifs.danger, 'image', 'Please provide either an image or description' )
                    vm.$set(vm.notifs.danger, 'description', 'Please provide either an image or description' )
                    validation = false
                } 
                if(vm.form.imageUpload) {
                    let imageType = vm.form.imageUpload.type.split("/");
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
                    if(vm.form.imageUpload.size > uploadLimit) {
                        vm.$set(vm.notifs.danger, 'image', 'Image exceeds upload limit of '+vm.convertSize(uploadLimit,.00001, 'MB')+', current : '+ vm.convertSize(vm.form.imageUpload.size,.00001, 'MB'))
                        validation = false
                    }
                }
            }
            return validation
        },
        deletePost() {
            this.$emit('delete-action', this.postData.id, this.rowIn, this.pageIn)
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
    },
    created: function() {
        //Set Props to local data
        this.setProfileImage()
        this.$set(this.form, 'title', this.postData.title)
        this.$set(this.form, 'description', this.postData.description)
        this.$set(this.form, 'image', this.postData.image)
    }
}
</script>

<style scoped>
    .card-header a {
        color: #fff;
        display: inline-block;
        margin-left: 5px;
        font-weight: bold;
        font-size: 110%;
    }
    .card-header .btn {
        width: 2.5em;
        height: 2.5em;
        padding: 5px;
    }
    .card-header .btn.primary { 
        color: #fff;
    }
    .card-header .btn.danger { 
        color: #ff0000;
    }
    .card-header .btn.success { 
        color: #44ff08;
    }
    .card-header .btn.warning { 
        color: #ffe000;
    }
    .card-body h3::first-letter {
        text-transform: uppercase;
    }
    .card-body p{
        padding: 15px;
        border-left: solid 2px #e4e4e4;
    }
    .responsive-image {
        max-width: 900px;
        width: 100%;
        height: auto;
    }
    .responsive-thumbnail {
        max-width: 50px;
        width: auto;
        max-height: 50px;
        height: auto;
        border-radius: 50%;
    }
</style>