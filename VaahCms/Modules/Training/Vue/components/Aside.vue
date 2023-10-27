<script setup>
import {reactive, ref} from 'vue';

import Menu from 'primevue/menu';

import { usePracticeStore } from '../stores/store-practices';

const store = usePracticeStore();

const reset=store.resetQuery;


const inputs = {
}
const data = reactive(inputs);

const height = ref(window.innerHeight)

const menu = ref();

const items = ref([
    {
        label: 'Training',
        items: [
            {
                label: 'Dashboard',
                icon: 'fa-regular fa-chart-bar',
                to: "/"
            },
            {
                label: 'Crud',
                icon: 'fa-regular fa-chart-bar',
                to: "/practices"
            },
        ]
    },
]);

function resetQuery(e) {
        store.resetQuery();

}

</script>
<template>

    <div v-if="height">
        <Menu :model="items"  class="w-full" @click="resetQuery" />
    </div>

</template>


