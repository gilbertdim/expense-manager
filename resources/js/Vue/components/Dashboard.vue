<template>
    <div class="h-96" id="expense_chart"></div>
</template>

<script>
    export default {
        props: ['header'],
        beforeMount() {
            this.header.title = 'My Expenses';
            this.header.path = 'Dashboard';        
        }
    }
</script>
