<template>
  <div class="container-fluid big-banner">
        <div class="row justify-content-center bg-white">
            <div class="col-md-10">
                <div class="content text-center">
                   <div class="inner">
                       <h2>Create A Profile Right Now</h2>
                        <p>Start building your profile, be visible and get connected</p>
                        <router-link to="/register" class="btn animated faster">
                                Register to STAT 
                                    <svg class="bi bi-box-arrow-in-right" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8.146 11.354a.5.5 0 010-.708L10.793 8 8.146 5.354a.5.5 0 11.708-.708l3 3a.5.5 0 010 .708l-3 3a.5.5 0 01-.708 0z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9A.5.5 0 011 8z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M13.5 14.5A1.5 1.5 0 0015 13V3a1.5 1.5 0 00-1.5-1.5h-8A1.5 1.5 0 004 3v1.5a.5.5 0 001 0V3a.5.5 0 01.5-.5h8a.5.5 0 01.5.5v10a.5.5 0 01-.5.5h-8A.5.5 0 015 13v-1.5a.5.5 0 00-1 0V13a1.5 1.5 0 001.5 1.5h8z" clip-rule="evenodd"/>
                                </svg>
                        </router-link>
                   </div>
                </div>
            </div>    
        </div> 
    </div>
</template>

<script>
export default {
    name: 'bigBanner'
}
</script>

<style scoped>
    .big-banner .content {
        border: solid 2px #e0e0e0;
        border-image-source: linear-gradient(to right, rgba(160, 160, 160, .1) 0%,rgb(255, 235, 0) 51%,rgba(160,160,160,0.1) 100%);
        border-image-slice: 1;
        padding: 25px;
        background-image: url('/images/mirrored-squares.png');
    }
    .big-banner p {
        margin: 0em 0px 2em;
        border-top: solid 1px #fff7f7;
        padding-top: .5em;
    }
    @media screen and (min-width: 768px) {
        .big-banner .content {
            margin-bottom: 5rem ;
            margin-top: 5rem;
        }
        .big-banner .content .inner {
            padding: 50px;
        }
    }
    @media screen and (max-width: 767px) {
        .big-banner .content {
            margin-bottom: 15px ;
            margin-top: 15px;
        }
    }
    .big-banner .btn {
        font-size: 120%;
        border-radius: 0px;
        width: 100%;
        max-width: 400px;
        padding: 25px;
        background-color: #44ff08;
        animation-name: colorOrigin;
    }
    .big-banner .btn svg{ 
        width: 1.5em;
        height: 1.5em;
        margin-left: 15px;
        vertical-align: text-bottom;
    }
    .big-banner .btn:hover {
        animation-name: colorHover;
    }
    @keyframes colorHover {
        from {
            background-color: #44ff08;
        }
        to {
            background-color: #e8e8e8;
        }
    }
    @keyframes colorOrigin {
        from {
            background-color: #e8e8e8;
        }
        to {
            background-color: #44ff08;
        }
    }
</style>