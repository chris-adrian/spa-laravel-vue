<template>
    <div id="welcome">
        <VideoBg />
        <BigBanner />
        <Columns />
        <Author />
    </div>
</template>

<script>
import VideoBg from '../components/VideoBg'
import BigBanner from '../components/BigBanner'
import Columns from '../components/Columns'
import Author from '../components/Author'

export default {
    name: 'welcome',
    components: {
        VideoBg,
        BigBanner,
        Columns,
        Author
    }
}
</script>

<style>

</style>