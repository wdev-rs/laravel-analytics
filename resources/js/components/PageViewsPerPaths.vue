<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Pageviews</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(pageViews, path) in initialData">
                    <td class="p-1">{{path}}</td>
                    <td class="p-1 text-center">{{pageViews}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total:</th>
                    <th class="text-center">{{Object.values(initialData).reduce((a, b) => a + b, 0)}}</th>
                </tr>
            </tfoot>
        </table>
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
