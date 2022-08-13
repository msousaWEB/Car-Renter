<template>
<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titles" :key="key">{{t.title}}</th>
                <th v-if="view || edit || del">Ações</th>
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
                <td>
                    <button v-if="view" class="btn btn-outline-primary btn-sm" title="Visualizar"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <button v-if="edit" class="btn btn-outline-secondary btn-sm" title="Atualizar Marca"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button v-if="del" class="btn btn-outline-danger btn-sm" title="Excluir"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>   

<script>
    export default {
        props: ['data', 'titles', 'view', 'edit', 'del'],
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