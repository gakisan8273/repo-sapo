<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        {{ title }}
                    </div>
                    <test message="{{ "message" }}"></test>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import test from './test.vue';
    export default {
        data: function() {
            return {
                message: "tes t"
            }
        },
        props: ['title'],
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
