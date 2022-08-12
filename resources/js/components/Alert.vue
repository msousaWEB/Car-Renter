<template>
        
<div :class="styleAlert" role="alert">
  {{title}}
  <hr>

  <span v-if="detail.data.response">
    {{detail.data.response}}
  </span>
  
  <span v-if="detail.data.id">{{'ID da marca cadastrada: ' + detail.data.id}}</span>

  <ul v-if="detail.data.errors">
    <li v-for="e, key in detail.data.errors" :key="key">
        {{e[0]}}
    </li>
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