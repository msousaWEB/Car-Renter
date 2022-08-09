<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Marcas</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="inputId" class="form-label">ID</label>
                            <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID da marca">
                            <div id="idHelp" class="form-text">Opcional: informe o id o registro.</div>
                        </div>

                        <div class="col mb-3">
                            <label for="inputName" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Nome da marca">
                            <div id="nameHelp" class="form-text">Opcional: informe o nome da marca.</div>
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