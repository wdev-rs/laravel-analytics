<template>
    <div>
        <p v-for="(pageViews, date) in initialData">{{date}} : {{pageViews}}</p>
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
        console.log('page views per days mounted!');
    },

    methods: {

    },
}
</script>
