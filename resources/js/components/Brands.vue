<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- CARD DE BUSCA -->
                <card-component title="Buscar marcas">
                    <template v-slot:content>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component title="ID" id="inputId" idHelp="idHelp" helpText="Opcional: informe o id da marca.">  
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID da marca">
                                </input-container-component>
                            </div>


                            <div class="col mb-3">
                                <input-container-component title="Marca" id="inputName" idHelp="nameHelp" helpText="Opcional: informe o nome da marca.">  
                                    <input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Nome da marca">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                    </template>
                </card-component>
                <!-- FIM CARD DE BUSCA -->

                <!-- CARD LISTAGEM DE MARCAS -->
                <card-component title="Relação de marcas">
                    <template v-slot:content>
                        <table-component></table-component>
                    </template>
                    <template v-slot:footer>
                        <button type="submit" data-bs-toggle="modal" data-bs-target="#brandModal" class="btn btn-primary btn-sm float-end">Adicionar</button>
                    </template>
                </card-component>
                <!-- FIM CARD LISTAGEM DE MARCAS -->
            </div>
        </div>
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
                baseUrl: 'http://localhost:8000/api/v1/car-brand',
                brandName: '',
                brandImage: [],
                status:'',
                detailStatus: [],
            }
        },
        methods: {
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
                axios.post(this.baseUrl, formData, config)
                    .then(response => {
                        this.status = 'sucesso'
                        this.detailStatus = response
                    })
                    .catch(errors => {
                        this.status = 'erro'
                        this.detailStatus = errors.response
                    })
            }
        }
    }
</script>