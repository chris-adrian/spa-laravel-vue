<template>
    <div class="modal animated fadeIn faster" tabindex="-1" role="dialog" id="globalModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title ? title : 'Modal Title'}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ body ? body : 'Modal Body '}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" @click="action()">{{type ? type : 'confirm'}}</button>
                    <button type="button" class="btn btn-secondary" @click="deny()">Cancel</button>
                    <!-- data-dismiss="modal" --> 
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'modal',
    props: {
        title: String,
        body: String,
        type: String
    },
    data() {
        return {
        }
    },
    methods: {
        action() {
            // console.log('confirmed')
            this.$emit('modal-action', this.$props.type);
            this.disposeModal();
        },
        deny() {
            // console.log('denied')
            this.$emit('modal-action', false);
            this.disposeModal();
        },
        disposeModal() {
            $('#globalModal').modal('hide');
        }
    },
    created: function() {
        $('#globalModal').on('hide.bs.modal', function (e) {
            this.$emit('modal-action', false);
        });
    }
}
</script>

<style scoped>
    button {
        text-transform: uppercase;
    }
</style>