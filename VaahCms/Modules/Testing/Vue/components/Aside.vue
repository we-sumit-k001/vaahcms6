<script setup>
import {reactive, ref} from 'vue';


import Menu from 'primevue/menu';



const inputs = {
}
const data = reactive(inputs);
const height = ref(window.innerHeight)

const menu = ref();

const items = ref([
    {
        label: 'Testing',
        items: [
            {
                label: 'Dashboard',
                icon: 'fa-regular fa-chart-bar',
                to: "/"
            },
            {
                label: 'Test Crud',
                icon: 'fa-regular fa-chart-bar',
                to: "/tests"
            },
            {
                label: 'User Crud',
                icon: 'fa-regular fa-chart-bar',
                to: "/users"
            },
            {
                label: 'Taxonomy Crud',
                icon: 'fa-regular fa-chart-bar',
                to: "/taxonomies"
            },
        ]
    },
]);

</script>
<template>

    <div v-if="height">
        <Menu :model="items"  class="w-full" />
    </div>



</template>


