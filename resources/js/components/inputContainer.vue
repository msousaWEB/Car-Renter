<template>
    <div class="form-group">
        <label :for="id" class="form-label">{{title}}</label>
        <slot></slot>
        <div :id="idHelp" class="form-text">{{helpText}}</div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'title', 'idHelp', 'helpText']
    }
</script>