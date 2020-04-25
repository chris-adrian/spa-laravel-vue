<template>
   <div class="container columns">
        <div class="row mt-5 mb-5">
            <div class="col-md-12 top">
                <h2>Key features</h2>
            </div>
        </div>
        <div class="row mt-5 mb-5">
            <div class="col-md-4">    
                <div class="row">
                    <div class="col-md-12 header">
                        <h3>Create Posts</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 content">
                        <svg class="bi bi-chat-square-dots" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v8a1 1 0 001 1h2.5a2 2 0 011.6.8L8 14.333 9.9 11.8a2 2 0 011.6-.8H14a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v8a2 2 0 002 2h2.5a1 1 0 01.8.4l1.9 2.533a1 1 0 001.6 0l1.9-2.533a1 1 0 01.8-.4H14a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd"/>
                            <path d="M5 6a1 1 0 11-2 0 1 1 0 012 0zm4 0a1 1 0 11-2 0 1 1 0 012 0zm4 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                    </div>
                </div>
            </div>    
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 header">
                        <h3>Build your profile</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 content">
                        <svg class="bi bi-person-lines-fill" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 100-6 3 3 0 000 6zm7 1.5a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zm-2-3a.5.5 0 01.5-.5h4a.5.5 0 010 1h-4a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h4a.5.5 0 010 1h-4a.5.5 0 01-.5-.5zm2 9a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 header">
                        <h3>View members</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 content">
                        <svg class="bi bi-person-square" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div> 

        <div class="row mt-5 mb-5">
            <div class="col-md-12 bottom">    
                <p>
                    Currently these are the key features this APP has to offer.<br/> 
                    hoping to expand it a bit further in the future, or create new ones entirely with this as a basis.   
                </p>    
            </div>    
        </div> 
    </div>
</template>

<script>
export default {
    name: 'columns'
}
</script>

<style scoped>
    .columns .header,
    .columns .content,
    .columns h2,
    .columns p {
        text-align: center;
    }
    .columns .top {
        border-bottom: solid 2px #e0e0e0;
        padding-bottom: 25px;
    }
    .columns .bottom {
        border-top: solid 2px #e0e0e0;
        padding-top: 25px;
    }
    .columns svg {
        width: 8em;
        height: 8em;
    }
</style>