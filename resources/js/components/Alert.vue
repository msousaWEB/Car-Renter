<template>
        
<div :class="styleAlert" role="alert">
  {{title}}
  <hr>
  <p v-if="detail.head">{{detail.head}}<br></p>
  
  <ul v-if="detail.msg">
    <li v-for="e, key in detail.msg" :key="key">{{e[0]}}</li>
  </ul>

  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
</template>

<script>
    export default {
        props: ['type', 'detail', 'title'],
        computed: {
            styleAlert() {
                return 'alert alert-dismissible fade show alert-'+this.type
            }
        }
    }
</script>