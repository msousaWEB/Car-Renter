<template>
        
<div :class="styleAlert" role="alert">
  A simple {{type}} alert—check it out!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
</template>

<script>
    export default {
        props: ['type'],
        computed: {
            styleAlert() {
                return 'alert alert-dismissible fade show alert-'+this.type
            }
        }
    }
</script>