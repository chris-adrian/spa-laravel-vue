<template>
    <div class="row card mt-3">
        <div class="col-md-12 card-body">
            <h2>Post Unavailable</h2>
            <p>
                Currently no post is listed,
                <span v-if="this.$route.name == 'posts'">
                    Try creating one from above.    
                </span> 
                <span v-else>be the first one to <router-link to="/posts">create!</router-link></span>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'postRowHolder',
    components: {

    },
    created: function() {
        console.log()
    }
}
</script>

<style>

</style>