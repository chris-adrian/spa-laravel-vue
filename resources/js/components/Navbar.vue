<template>
    <nav class="navbar animated faster navbar-expand-lg"> 
        <div class="container">
            <router-link class="navbar-brand" to="/">
                <img src="favicon.ico" />
                <span class="app-title">stat<small><br/>Profile Management</small></span>
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <svg class="bi bi-justify" focusable="false" role="img" aria-hidden="true" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor">
                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">             
                <ul class="navbar-nav mr-auto">
                    <!-- <li class="nav-item">
                        <router-link to="somelink" class="nav-link">somelink</router-link>
                    </li> -->
                </ul> 
                <ul v-if="user" class="navbar-nav pull-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ fullName() }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animated fadeIn faster text-right" aria-labelledby="navbarDropdown">
                        <router-link class="dropdown-item" :to="fullName(true)" :key="$route.fullpath">My Profile</router-link>
                        <router-link class="dropdown-item" to="posts">My Post(s)</router-link>
                        <router-link class="dropdown-item" to="account">My Account</router-link>
                        <router-link class="dropdown-item" to="about">About</router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="" @click.prevent="signOut">Logout</a>
                        </div>
                    </li>
                </ul>
                <ul v-else class="navbar-nav pull-right">
                    <li class="nav-item">
                        <router-link to="about" class="nav-link">About</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="signin"> Login </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link text-green" to="register"> Register </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {    
    name: 'navbar',
    components: {

    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user'
        }),
    },
    methods: {
        ...mapActions({
            signOutAction: 'auth/signOut'
        }),
        fullName(isPath  = false) {
            let joint, UFN = _.cloneDeep(this.user.fullname), resName = "";
            
            if(isPath) {
                joint = '.'; 
                UFN.first_name = UFN.first_name.replace(/\s+/g,'-')
                UFN.last_name = UFN.last_name.replace(/\s+/g,'-')
            } else {
                joint = ' ';
            }
            if(UFN.middle_name) {
                UFN.middle_name = UFN.middle_name.replace(/\s+/g,'-')
                joint = joint+UFN.middle_name+joint 
            }

            resName = UFN.first_name+joint+UFN.last_name;

            resName = isPath ? resName.toLowerCase() : resName;
            return resName;
        },
        signOut(){
            this.signOutAction().then(()=>{
                this.$router.replace({
                    name: 'signin'
                })
            })
            .catch(()=> {
                this.$router.replace({
                    name: 'register'
                })
            });
        }
    }
}
</script>

<style>
    #route-home.guest .nav-wrapper.set {
        height: 0px !important;  
    }
    .app-title {
        text-transform: uppercase;
        font-weight: bold;
        font-size: 25px;
        padding-left: 5px;
        display: inline-block;
        vertical-align: bottom;
        line-height: .5;
    }
    .app-title small{
        font-size: 40%;
        line-height: 1.5;
    }
    .nav-wrapper.set > nav{ 
        position:fixed;
        top: 0;
        width: 100%;
        z-index:1;
        background-color: #404040;
    }
    #route-home.guest .nav-wrapper.set:not(.reveal):not(.conceal) > nav {
        background-color: transparent;
    }
    .nav-wrapper.reveal > nav{
        animation-name: slideInDown;
    }
    .nav-wrapper.conceal > nav{
        animation-name: slideOutUp;
    }
    .nav-wrapper.reveal > nav,
    .nav-wrapper.conceal > nav {
        border: none;
        background-color: #191919;
        background-color: rgba(19, 19, 19, 0.8);
    }   
    .navbar-nav.pull-right {
        text-align: right;
    }
    .navbar-nav .nav-link {
        font-size: 90%;
        text-transform: uppercase;
        display: inline-block;
    }
    .nav-wrapper.set .nav-item {
        color: #c1c1c1;
    }
    .nav-wrapper.set .nav-link { 
        color: inherit;
    }
    .navbar-nav .nav-link:hover, .navbar-nav .nav-link:active {
        /* text-decoration: underline; */
        /* color: #fff; */
        animation-duration: .5s;
        animation-fill-mode: both;
        animation-name: linkActive;
    }
    .nav-wrapper.set .navbar-toggler,
    .nav-wrapper.set .navbar-brand,
    .navbar-nav .nav-link.router-link-active { 
        color: #fff;
    }
    @media all and (min-width: 992px) {
        .navbar-nav .nav-item:not(:last-child) {
            border-right: solid 1px rgb(171, 171, 171);
            margin-right: 5px;
            padding-right: 5px;
            border-image-source: linear-gradient(to bottom, rgba(30,87,153,0) 0%,rgb(171, 171, 171) 51%,rgba(125,185,232,0) 100%);
            border-image-slice: 1;
        }
    }
    @media all and (max-width: 991px) {
        .nav-wrapper.set .navbar-collapse {
            background: rgb(51, 51, 51);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    }
    @keyframes linkActive {
        /* from {
            color: #c1c1c1;;
        } */
        to {
            color: #fff;
        }
    }
</style>