<template>
    <div class="container-fluid">
        <!-- <iframe id="ytplayer" class="fixed-content "
        src="https://www.youtube.com/embed/M7lc1UVf-VE?autoplay=1&origin=http://example.com"
        frameborder="0">
        </iframe> -->
        <!-- <div class="responsive-wrapper"> -->
        <div class="row media-area">
            <video class="fixed-content" loop autoplay muted>
            <source src="/media/video-cover.mp4" type="video/mp4">
            Your browser does not support the video tag.
            </video>
            <div class="overlay-wrapper">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <h3>
                                    STAT is a sample Profile Management App<br/>
                                    Created by Chris as a pet project using laravel for a backend and Vue managing the frontend
                                </h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>   
    </div>
</template>

<script>
export default {
    name: 'videoBg'
}
</script>

<style>
    .media-area {
        position: relative;
    }
    .responsive-wrapper {
        position: relative;
        padding-bottom: 56.25%;
        padding-top: 25px;
        height: 0;
    }
    .responsive-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .fixed-content {
        width: 100%;
        height: 600px;
        min-height: 500px;
        max-height: 1000px;
        height: 70vh;
        background-color: #fff;
    }
    .overlay-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        text-align: center;
        background: rgba(0,0,0,0.8);
    }
    .overlay-wrapper table {
        width: 100%;
        height: 100%;
        
    }
    .overlay-wrapper table h3{
        color: #fff;
        font-size: 180%;
        /* font-family: 'Allerta Stencil', sans-serif; */
        font-family: 'Averia Serif Libre', cursive;
    }
</style>