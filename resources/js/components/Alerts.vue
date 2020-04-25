<template>
    <div>

        <div v-if="setMessage">
            <!-- {{ alertBody }} 
            v-if="Object.keys(alertBody.content).length > 0 "
            -->
            <!-- {{ alertBody.content }} -->
            <div v-if="alertBody.content.message" :class="'form-alerts alert-'+alertClass.content">
                <ul v-if="Array.isArray(alertBody.content.message)">
                    <li v-for="c in alertBody.content.message" :key="c">
                        <!-- {{ c }} -->
                        <span v-html="c"></span>
                    </li>
                </ul>
                <p v-else><span v-html="alertBody.content.message"></span></p>
            </div>
        </div>
        <div v-else>
            <small class="form-text text-muted">{{ placeholder ? placeholder : '' }}</small>
        </div>
    </div>
</template>

<script>
export default {
    name: 'alerts',
    props: {
        alerts: undefined,
        for: String,
        placeholder: String
    },
    data() {
        return {
            alertClass: {
                content: 'primary'
            },
            alertBody: {
                content: {},
                // list: {}
            }
        }
    },
    computed: {
        setMessage: function() {
            let isSet = false, myAlerts = this.alerts, afor = this.$props.for;
            // this.alertBody = myAlerts;
            
            if(afor.indexOf("|") !== -1){
                afor = afor.split("|")
                // console.log('type array')
            }   

            for(let alertKey in myAlerts) {

                if(Object.keys(myAlerts[alertKey]).length > 0) {

                    for(let innerAlertKey in myAlerts[alertKey]) {
                        
                        if(Array.isArray(afor)) {
                            // Multiple condition
                            for (let i = 0; i < afor.length; i++) {

                                if(innerAlertKey == afor[i]) {
                                    isSet = true;
                                    this.$set(this.alertClass, 'content', alertKey);
                                    this.$set(this.alertBody.content, 'message',myAlerts[alertKey][innerAlertKey]);

                                    // if(Array.isArray(myAlerts[alertKey][innerAlertKey])){
                                    //     console.log('is array!')

                                    //     let tempArr = myAlerts[alertKey][innerAlertKey]
                                    //     let tempMsg = ''
                                    //     for (let a = 0; a < tempArr.length; a++) {
                                    //         tempMsg += tempArr[a]                                     
                                    //     }
                                    //     this.$set(this.alertBody.content, 'message',tempMsg);
                                    // } else {
                                    //     this.$set(this.alertBody.content, 'message',myAlerts[alertKey][innerAlertKey]);
                                    // }
                                } else {

                                }
                            }
                        } else {
                            // Single condition
                            if(innerAlertKey == afor) {
                                isSet = true;
                                this.$set(this.alertClass, 'content', alertKey);
                                this.$set(this.alertBody.content, 'message',myAlerts[alertKey][innerAlertKey]);

                                // if(Array.isArray(myAlerts[alertKey][innerAlertKey])){
                                //     console.log('is array!')

                                //     let tempArr = myAlerts[alertKey][innerAlertKey]
                                //     let tempMsg = ''
                                //     for (let a = 0; a < tempArr.length; a++) {
                                //         tempMsg += tempArr[a]                                     
                                //     }
                                //     this.$set(this.alertBody.content, 'message',tempMsg);
                                // } else {
                                //     this.$set(this.alertBody.content, 'message',myAlerts[alertKey][innerAlertKey]);
                                // }
                            }
                        }
                    }
                }
            }

            return isSet;         
        }
    },
    methods: {
    },
    created: function() {
    },
    watch: {
      alerts: function(to, from) {
        console.log('changes to prop')
      }
    }
}
</script>

<style>
    
</style>