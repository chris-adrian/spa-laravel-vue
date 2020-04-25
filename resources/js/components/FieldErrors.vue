<template>
    <div class="form-errors alert-danger">
        <ul v-if="Array.isArray(errors)"  >
        <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul>
        <span v-else>{{ errors}}</span>
    </div>
</template>

<script>
export default {
    name: 'fieldErrors',
    props: {
        errors: [Array, String]
    },
    data() {
        return {
        }
    }
}
</script>

<style scoped>
    .form-errors ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
</style>