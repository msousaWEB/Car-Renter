<template>
<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titles" :key="key">{{t.title}}</th>
                <th v-if="view.visible || edit.visible || del.visible">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="obj, key in filteredData" :key="key">
                <td v-for="val, valKey in obj" :key="valKey">
                    <span v-if="titles[valKey].type == 'text'">{{val}}</span>
                    <span v-if="titles[valKey].type == 'date'">{{val | dateTimeFormatGlobal}}</span>
                    <span v-if="titles[valKey].type == 'image'">
                        <img :src="'/storage/'+ val" width="30" length="30"/>
                    </span>
                </td>
                <td v-if="view.visible || edit.visible || del.visible">
                    <button v-if="view.visible" 
                        @click="setStore(obj)" 
                        class="btn btn-outline-primary btn-sm" 
                        title="Visualizar" 
                        :data-bs-toggle="view.dataToggle" 
                        :data-bs-target="view.dataTarget">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <button v-if="edit.visible"
                        @click="setStore(obj)"                       
                         class="btn btn-outline-secondary btn-sm" 
                         title="Atualizar Marca"
                        :data-bs-toggle="edit.dataToggle" 
                        :data-bs-target="edit.dataTarget">
                         <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <button v-if="del.visible"
                        @click="setStore(obj)" 
                        class="btn btn-outline-danger btn-sm" 
                        :data-bs-toggle="del.dataToggle" 
                        :data-bs-target="del.dataTarget"
                        title="Excluir"><i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>   

<script>
    export default {
        props: ['data', 'titles', 'view', 'edit', 'del'],
        methods: {
            setStore(obj) {
                this.$store.state.transiction.status = ''
                this.$store.state.transiction.msg = ''
                this.$store.state.item = obj
            }
        },
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