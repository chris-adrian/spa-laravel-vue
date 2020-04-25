<template>
  <div>
    <div class="container">
      <!-- {{ this.post.list }} -->
      <!-- Post Placeholder -->
      <postPlaceHolder v-if="!hasPost" />
      <!-- Post Rows -->
      <div v-else class="post-wrapper" v-for="(page, index) in post.list" :key="index">
        <PostRow v-for="(post, i) in page" :key="post.id" :pageIn="index" :rowIn="i" :postData="post" v-on:delete-action="confirmDelete" :editable="isEditable(post.user_id)"/>
      </div>
      <!-- Load More Post -->
      <div v-if="post.data.next_page_url" class="post-nav text-center mt-3">
        <button class="btn" @click="loadMore()">
          <svg class="bi bi-chevron-double-down" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 01.708 0L8 12.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z" clip-rule="evenodd"/>
            <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 01.708 0L8 8.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z" clip-rule="evenodd"/>
          </svg>
        </button>
      </div>
    </div>
    <modal v-on:modal-action="deletePost" :type="modal.type" :title="modal.title" :body="modal.body"/>
    <loader v-if="!contentReady" />
  </div>
</template>

<script>
import PostRow from './PostRow'
import Vue from 'vue'
import modal from '../components/Modal'
import loader from '../components/Loader'
import postPlaceHolder from '../components/PostRowHolder'

export default {
    name: 'PostList',
    props: {
      reload: undefined,
      allEntries: false
    },
    components: {
      modal,
      loader,
      postPlaceHolder,
      PostRow
    },
    data(){
      return {
        post: {
          data: '',
          list: {},
          id: Number,
          row: Number,
          page: String
        },
        modal: {
          type: '',
          title: '',
          body: ''
        },
        edit: false,
        contentReady: false,
        hasPost: false
      }
    },
    methods: {
      isEditable(id) {
        if(this.$store.state.auth.user) {
          if(this.$store.state.auth.user.id == id) {
            return true
          }
        }
        return false
      },
      getPosts(page) {
        let vm = this;
        let rParams;
        this.contentReady = false;

        if(page) {
          rParams = {
            all: this.allEntries,
            page: page
          }
        } else {
          rParams = {
            all: this.allEntries
          }
        }
        
        axios.post('post/list', rParams)
        .then((res)=>{
          this.$set(this.post, 'data', res.data)
          this.loadData(page);
        })
        .catch((err)=>{
          console.log('Error in fetching post list : '+err);
        })
      },
      loadMore(){ 
        this.getPosts(this.post.data.current_page+1)
      },
      loadData(page) {
        let cpage = page ? page : 1
        let vm = this;
        let pList = vm.post.list;
        this.$set(pList, 'page'+cpage, vm.post.data.data)

        for(let p in pList) {
          // console.log(Object.keys(pList[p]).length)
          if(Object.keys(pList[p]).length > 0){
              this.hasPost = true;
          }
        }
        // console.log(Object.keys(this.post.list).length)
        
        this.contentReady = true;
      },
      confirmDelete(postId, row, page) {
        this.post.id = postId
        this.post.row = row
        this.post.page = page
        this.modal.type = 'delete'
        this.modal.title = 'Remove Post?'
        this.modal.body = 'This will delete your post permanently!'
        $('#globalModal').modal('toggle')
      },
      deletePost(confirmed){
        let vm = this
        if(confirmed) {
          axios.post('post/delete',{
            id: vm.post.id
          })
          .then((res)=> {
            $('*[data-post-id="'+vm.post.id+'"]').fadeOut(500,function(){
              vm.post.list[vm.post.page].splice(vm.post.row, 1)
              vm.resetTarget();
            })  
          })
          .catch((err)=> {
              vm.$set(vm.notifs, 'danger', err.response.data.errors);
          });
        } else {
          vm.resetTarget();
        }
      },
      resetTarget(){ 
        // Modal
        this.modal.type = ''
        this.modal.title = ''
        this.modal.body = ''
        // Post Variables
        this.post.id = Number
        this.post.row = Number
        this.post.page = String
      },
      scrollHandle(e) {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
          if(this.post.data.next_page_url){
            this.loadMore();
          } else {
            // console.log('next page unavailable')
          }
        }
      }
    },
    created: function() {
      this.getPosts();
      window.addEventListener('scroll', this.scrollHandle);
    },
    destroyed () {
      window.removeEventListener('scroll', this.scrollHandle);
    },
    watch: {
      reload : function() {
        if(this.$props.reload) {
          this.getPosts();
        }
        this.$emit('reloaded')
      }
    }
}
</script>

<style scoped>
  .post-nav .btn {
    padding: 5px;
    width: 3em;
    height: 3em;
    color: #000;
    border-bottom: solid 3px black;
    border-radius: 0px;
  }
  .post-nav .btn:hover,.post-nav .btn:active { 
    color: #fff;
  }
</style>