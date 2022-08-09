<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Marcas</div>

                <div class="card-body">
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
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</template>

<script>

</script>