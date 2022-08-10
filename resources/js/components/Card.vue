<template>
    <div class="card mb-5">
        <div class="card-header">{{title}}</div>

        <div class="card-body">
            <slot name="content"></slot>
        </div>

        <div class="card-footer">
            <slot name="footer"></slot>
        </div>

    </div>
</template>

<script>
    export default{
        props: ['title']
    }
</script>