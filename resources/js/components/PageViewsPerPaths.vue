<template>
    <div>
        <p v-for="(pageViews, path) in initialData">{{path}} : {{pageViews}}</p>
    </div>
</template>

<script>

export default {
    props: ['initialData', 'baseUrl'],
    data() {
        return {

        };
    },
    mounted() {
        console.log('page views per paths mounted!');
    },

    methods: {

    },
}
</script>
