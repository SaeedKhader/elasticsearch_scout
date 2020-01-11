<template>
    <div v-on:click="clicked" class="completion"><h5>{{ completion.text }}</h5></div>
</template>

<script>
    export default {
        name: "completion-suggestion",
        props: ['completion'],
        methods: {
            clicked: function () {
                this.$emit("suggestion-clicked", this.completion.text);
            }
        }
    }
</script>

<style scoped>
    .completion {
        width: 100%;
        height: 30px;
        border: 1px solid lightblue;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .completion:hover {
        cursor: pointer;
        background: rgba(207,226,252,0.73);
    }
    .completion h5 {
        margin: 0;
        padding-left: 4px;
    }
</style>
