<template>
    <div class="row">
        <div class="col-md-12">
            <PostForm v-on:new-post="reloadList"/>
            <hr/>
            <PostList v-if="load"/>
        </div>
    </div>
</template>

<script>
import PostForm from '../components/PostForm'
import PostList from '../components/PostList'

export default {
    name: 'posts',
    components: {
        PostForm,
        PostList
    },
    data() { 
        return {
            modal: {
                type: '',
                title: '',
                body: ''
            },
            inputReady: true,
            load: true
        }
    },
    head: {
        title: function () {
            return {
                inner: 'My Post'
            }
        },
        meta: [
            { name: 'description', content: 'Post Listings', id: 'desc' }
        ]
    },
    methods: {
        reloadList() {
            this.load = false
            this.$nextTick(() => {
                this.load = true
            })
        }
    }
}
</script>

<style>

</style>