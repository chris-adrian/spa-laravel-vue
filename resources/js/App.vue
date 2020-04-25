<template>
    <div :id="'route-'+this.$route.name" :class="logged">
        <div class="nav-wrapper">
            <navbar />
        </div>
        <router-view></router-view>
        <pageFooter />
    </div>
</template>

<script>
import navbar from './components/Navbar'
import pageFooter from './components/Footer'

export default {
    Name: 'app',
    components: {
        navbar,
        pageFooter
    },
    computed: {
      logged: function() {
        let rVal = 'guest';
        if(this.$store.state.auth.user !== null) {
          rVal = 'user';
        }
        return rVal;
      }
    },
    methods: {
        navbarInit() {
            let navC = $('.nav-wrapper')
            
            let navH = navC.height()
            // 
            navC.css('height', navH).addClass('set')

            let prevSt = -1
            $(window).scroll(function() {
                var st = $(this).scrollTop()

                if (st >= navH) {
                    navC.removeClass('standby')
                    if(st > prevSt) {
                        //Hide State
                        navC.removeClass('reveal').addClass('conceal')
                    } else {
                        navC.removeClass('conceal').addClass('reveal')
                    }
                }
                else {
                    //Remove all states
                    navC.removeClass('conceal').removeClass('reveal').addClass('standby')
                }
                prevSt = st
            });
        }
    },
    created: function() {
        let vm = this;
        $(function() {
            vm.navbarInit();
        });
    }
}
</script>

<style>
    body {
        min-width: 350px;
        background-color: #f1f1f1;
        background-image: url('/images/fresh-snow.png');
    }
    .text-green {
        color: #44ff08 !important;
    }
    .text-green:hover, .text-green:active {
        color: inherit !important;
    }
    .view-enter-active, .view-leave-active {
        animation-duration: .2s;
        animation-fill-mode: both;
    }
    /* Vue Transition */
    .view-enter-active { 
        animation-delay: .2s;
        animation-name: viewSlideInLeft;
    }
    .view-leave-active { 
        animation-name: viewSlideOutRight;
    }
    @keyframes viewSlideInLeft {
        from {
            transform: translate3d(-100%, 0, 0);
            visibility: hidden;
            opacity: 0;
        }
        to {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }
    @keyframes viewSlideOutRight {
        from {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }

        to {
            opacity: 0;
            visibility: hidden;
            transform: translate3d(100%, 0, 0);
        }
    }
    /* Cards */
    .card { 
        /* box-shadow: 0px 2px 6px rgba(0,0,0,0.2); */
        border: 0px;
        background-color: rgba(255,255,255,0.9);
    }
    .card .card-header {
        background-color: #404040;
        color: #fff;
    }
    .card .card-header h1{
        text-align: left;
        margin: 0px;
        font-size: 22px;
    }
    /* Alerts */
    .form-alerts {
        background-color: transparent;
        border: none;
    }
    .form-alerts ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .form-alerts p {
        margin: 0;
        padding: 0;
    }
    .form-alerts p,
    .form-alerts ul li { 
        font-size: 80%;
        text-align: left;
    }
    .form-alerts.alert-primary {
        border-top: solid 1px #fff;
    }
    .form-alerts.alert-danger {
        border-top: solid 1px #ff0000;
    }
    .form-alerts.alert-warning {
        border-top: solid 1px #ffe000;
    }
    .form-alerts.alert-success {
        border-top: solid 1px #44ff08;
    }
    .form-alerts.alert-primary p,
    .form-alerts.alert-primary ul li {
        color: #fff; 
    }
    .form-alerts.alert-danger p,
    .form-alerts.alert-danger ul li {
        color: #ff0800;
        
    }
    .form-alerts.alert-warning p,
    .form-alerts.alert-warning ul li {
        color: #ffe000; 
    }
    .form-alerts.alert-success p,
    .form-alerts.alert-success ul li {
        color: #44ff08;
        
    }
    /* Inputs */
    .form-control {
        border-radius: 0px;
        border: none;
        /* border-bottom: solid 1px #8c8c8c; */
        box-shadow: 0px 2px 4px rgba(0,0,0,0.06);
    }
    textarea {
        min-height: 100px;
        max-height: 200px;
    }
</style>