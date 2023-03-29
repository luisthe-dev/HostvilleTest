<template>
    <div :class="{hidden: !active}" v-bind:class="message_type" class="infoBox">
        {{ message }}
    </div>
</template>

<script>
    export default {
        name: 'InfoBox',
        props: ['message', 'message_type', 'active']
    }
</script>

<style scoped>
    .infoBox{
        display: block;
        position: absolute;
        bottom: 5px;
        width: 250px;
        border-radius: 4px;
        color: #ffffff;
        text-align: center;
        word-wrap: break-word;
        padding: 12px;
        font-weight: 500;
    }
    .hidden{
        display: none;
    }
    .success{
        background: #129532;
    }
    .error{
        background: #953212;
    }
</style>
