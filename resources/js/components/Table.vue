<template>
<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titles" :key="key">{{t}}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="b in data " :key="b.id">
                <th scope="row">{{b.id}}</th>
                <td>{{b.name}}</td>
                <td><img :src="'/storage/'+b.image" width="30" length="30"></td>
            </tr>
        </tbody>
    </table>
</div>
</template>   

<script>
    export default {
        props: ['data', 'titles']
    }
</script>