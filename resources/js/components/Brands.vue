<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <!-- CARD DE BUSCA -->
                <card-component title="Buscar marcas">
                    <template v-slot:content>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component title="ID" id="inputId" idHelp="idHelp" helpText="Opcional: informe o id da marca.">  
                                    <input v-model="search.id" type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID da marca">
                                </input-container-component>
                            </div>


                            <div class="col mb-3">
                                <input-container-component title="Marca" id="inputName" idHelp="nameHelp" helpText="Opcional: informe o nome da marca.">  
                                    <input v-model="search.name" type="text" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Nome da marca">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm float-end" @click="searchBrand()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- FIM CARD DE BUSCA -->
            </div>
            <div class="col-md-7">
                <!-- CARD LISTAGEM DE MARCAS -->
                <card-component title="Marcas Cadastradas">
                    <template v-slot:content>
                        <table-component 
                        :data="brands.data"
                        :view="{visible: true, dataToggle: 'modal', dataTarget:'#viewBrand'}"
                        :edit="true"
                        :del="{visible: true, dataToggle: 'modal', dataTarget:'#delBrand'}"
                        :titles="{
                            id: {title:'ID', type: 'text'},
                            name: {title:'Marca', type: 'text'},
                            image: {title:'Logo', type: 'image'},
                            created_at: {title:'Data de inclusão', type: 'date'}
                        }"
                        ></table-component>
                    </template>
                    <template v-slot:footer>
                        <div class="row">
                            <div class="col">
                                <paginate-component>
                                    <li v-for="link, key in brands.links" :key="key" :class="link.active ? 'page-item active' : 'page-item'" @click="pagination(link)">
                                        <a class="page-link" v-html="link.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#brandModal" class="btn btn-primary btn-sm float-end">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- FIM CARD LISTAGEM DE MARCAS -->
            </div>
        </div>

        <!-- MODAL ADICIONAR MARCAS -->
        <modal-component id="brandModal" title="Adicionar marca">
            <template v-slot:alerts>
                <alert-component type="success" :detail="detailStatus" title="Cadastro realizado com sucesso!" v-if="status == 'sucesso'"></alert-component>
                <alert-component type="danger" :detail="detailStatus" title="Cadastro de marca inválido" v-if="status == 'erro'"></alert-component>
            </template>
            <template v-slot:content>
                <div class="form-group">
                    <input-container-component title="Marca" id="newName" idHelp="newHelp" helpText="Informe o nome da marca.">  
                        <input v-model="brandName" type="text" class="form-control" id="newName" aria-describedby="newHelp" placeholder="Nome da marca">
                    </input-container-component>
                 </div>

                <div class="form-group">
                    <input-container-component title="Logo da marca" id="newImage" idHelp="imageHelp" helpText="Selecione a logo da marca.">  
                        <input @change="loadImage($event)" type="file" class="form-control-file" id="newImage" aria-describedby="imageHelp" placeholder="Imagem da marca">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" @click="save()">Salvar</button>
            </template>
        </modal-component>
        <!-- FIM MODAL ADICIONAR MARCAS -->

        <!-- MODAL VISUALIZAR MARCAS -->
        <modal-component id="viewBrand" title="Visualizar Marca">
            <template v-slot:alerts>
            </template>
            <template v-slot:content>
                <div class="row">
                    <div class="col">
                        <input-container-component title="ID:">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>
                    </div>
                    <div class="col">
                        <input-container-component title="Marca:">
                            <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                        </input-container-component>
                    </div>
                </div>
                <input-container-component title="Data de Cadastro:">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>
                <input-container-component title="Logo:">
                    <img v-if="$store.state.item.image" :src="'storage/' + $store.state.item.image">
                </input-container-component>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- FIM MODAL VISUALIZAR MARCAS -->

        <!-- MODAL REMOVER MARCAS -->
        <modal-component id="delBrand" title="Deseja remover esta Marca?">
            <template v-slot:alerts>
                <alert-component type="success" :detail="{message:''}" title="Marca removida com sucesso!" v-if="$store.state.transiction.status == 'sucesso'"></alert-component>
                <alert-component type="danger" :detail="{message:''}" title="Erro ao remover a marca!" v-if="$store.state.transiction.status == 'erro'"></alert-component>
            </template>
            <template v-slot:content v-if="$store.state.transiction.status != 'sucesso'">
                <div class="row">
                    <div class="col">
                        <input-container-component title="ID:">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>
                    </div>
                    <div class="col">
                        <input-container-component title="Marca:">
                            <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                        </input-container-component>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <button @click="deleteBrand()" type="button" class="btn btn-danger" v-if="$store.state.transiction.status != 'sucesso'">Remover</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- FIM MODAL REMOVER MARCAS -->

    </div>
</template>

<script>
    export default{
        computed: {
            token(){
                let token = document.cookie.split(';').find(indice => {
                    return indice.includes('token=')
                })
                if(token){
                    token = token.split('=')[1]
                }

                return token
            }
        },
        data() {
            return {
                apiUrl: 'http://localhost:8000/api/v1/car-brand',
                apiPagination: '',
                apiFilter: '',
                brandName: '',
                brandImage: [],
                status:'',
                detailStatus: {},
                brands: { data: []},
                search: {id:'', name:''}
            }
        },
        methods: {
            deleteBrand() {
                let confirmation = confirm('Tem certeza que deseja remover esta marca?')

                if(!confirmation) {
                    return false
                }

                let url = this.apiUrl + '/' + this.$store.state.item.id
                let formData = new FormData();
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'bearer ' + this.token
                    }
                } 

                formData.append('_method', 'delete')

        

                console.log(this.$store.state.transiction)
                axios.post(url, formData, config)
                    .then(response => {
                        console.log(response, 'apagou')
                        this.$store.state.transiction.status = 'sucesso'
                        this.$store.state.transiction.msg = response.data.msg
                        this.loadList()
                    })
                    .catch(errors => {
                        this.$store.state.transiction.status = 'erro'
                        this.$store.state.transiction.msg = 'Erro ao remover marca!'
                        console.log(errors.data)
                    })
            },

            searchBrand() {
                let filter = ''

                for(let key in this.search) {
                    if(this.search[key]) {
                        if(filter != '') {
                            filter += ';'
                        }

                        filter += key + ':like:' + this.search[key]
                    }
                }
                
                if(filter != '') {
                    this.apiPagination = 'page=1'
                    this.apiFilter = '&query='+filter
                } else {
                    this.apiFilter = ''
                }

                this.loadList()
            },

            pagination(link) {
                if(link.url) {
                    // this.apiUrl = link.url
                    this.apiPagination = link.url.split('?')[1]
                    this.loadList()
                }
            },

            loadList() {
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'bearer ' + this.token
                    }
                } 

                let url = this.apiUrl + '?' + this.apiPagination + this.apiFilter

                axios.get(url, config)
                    .then(response => {
                        this.brands = response.data
                        // console.log(this.brands)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },

            loadImage(e) {
                this.brandImage = e.target.files
            },

            save() {

                // programando o form semelhante ao postman
                let formData = new FormData();
                formData.append('name', this.brandName)
                formData.append('image', this.brandImage[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': 'bearer ' + this.token
                    }
                }

                // enviando os parametros para o axios
                axios.post(this.apiUrl, formData, config)
                    .then(response => {
                        this.status = 'sucesso'
                        this.detailStatus = {
                            head: 'ID da marca cadastrada: ' + response.data.id
                        }
                        this.loadList()
                    })
                    .catch(errors => {
                        this.status = 'erro'
                        this.detailStatus = {
                            msg: errors.response.data.errors
                        }
                    })
            }
        },

        mounted() {
            this.loadList()
        }
    }
</script>