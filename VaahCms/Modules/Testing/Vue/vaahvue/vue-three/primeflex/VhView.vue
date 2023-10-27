<script setup>
import {vaah} from '../../pinia/vaah.js'

import {ref} from "vue";

const props = defineProps({
    label: {
        type: String,
        default: null
    },
    label_width: {
        type: String,
        default: '150px'
    },
    value:{
        default: null,
    },
    type: {
        type: String,
        default: 'text'
    },
    can_copy:{
        type: Boolean,
        default: false
    }
})
const visible = ref(false);
//['label', 'value', 'type']

</script>
<template>
    <tr>
        <td :style="{width: label_width}"><b>{{vaah().toLabel(label)}}</b></td>
        <template v-if="can_copy">

        </template>

        <template v-else-if="deleted">

        </template>






        <template v-else-if="type==='yes-no'">
            <td colspan="2">
                <Tag value="Yes" v-if="value===1" severity="success"></Tag>
                <Tag v-else value="No" severity="danger"></Tag>
            </td>
        </template>


        <template v-else>
            <td  colspan="2" v-html="value"></td>
        </template>

    </tr>
</template>
