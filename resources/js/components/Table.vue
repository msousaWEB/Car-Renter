<template>
<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titles" :key="key">{{t.title}}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="obj, key in filteredData" :key="key">
                <td v-for="val, valKey in obj" :key="valKey">
                    <span v-if="titles[valKey].type == 'text'">{{val}}</span>
                    <span v-if="titles[valKey].type == 'date'">{{val}}</span>
                    <span v-if="titles[valKey].type == 'image'">
                        <img :src="'/storage/'+ val" width="30" length="30"/>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>   

<script>
    export default {
        props: ['data', 'titles'],
        computed: {
            filteredData() {
                let fields = Object.keys(this.titles)
                let filteredData = []

                this.data.map((item, key) => {
                    let filteredItem = {}

                    fields.forEach(field => {
                        filteredItem[field] = item[field]
                    })
                    filteredData.push(filteredItem)
                })

                return filteredData
            }
        }
    }
</script>