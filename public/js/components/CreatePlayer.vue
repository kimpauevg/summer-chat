<template>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
    $('#submit').click(() => {
        let form = $('#create-form')
        let data = form.serializeArray();
        console.log(data);

    })

</script>
