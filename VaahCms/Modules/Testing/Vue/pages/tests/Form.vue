<script setup>
import {onMounted, ref, watchEffect,computed} from "vue";
import { useTestStore } from '../../stores/store-tests'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useTestStore();
const route = useRoute();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }

    await store.getFormMenu();

    await store.loadChildren();


});

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

/*const selectedStateOptions = ref([]);


const showChildren = () => {
    const selectedCountry = store.assets.taxonomy_country_data.find(
        (country) => country.id === store.item.parent_id
    );

    if (selectedCountry) {
        selectedStateOptions.value = selectedCountry.children;
    } else {
        selectedStateOptions.value = [];
    }
};*/






</script>
<template>

    <div class="col-6" >

        <Panel class="is-small">

            <template class="p-1" #header>


                <div class="flex flex-row">
                    <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">
                            Update
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </div>

                </div>


            </template>

            <template #icons>


                <div class="p-inputgroup">
                    <Button label="Save"
                            class="p-button-sm"
                            v-if="store.item && store.item.id"
                            data-testid="tests-save"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"/>

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            class="p-button-sm"
                            data-testid="tests-create-and-new"
                            icon="pi pi-save"/>


                    <!--form_menu-->
                    <Button
                        type="button"
                        @click="toggleFormMenu"
                        class="p-button-sm"
                        data-testid="tests-form-menu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true" />
                    <!--/form_menu-->


                    <Button class="p-button-primary p-button-sm"
                            icon="pi pi-times"
                            data-testid="tests-to-list"
                            @click="store.toList()">
                    </Button>
                </div>



            </template>

            <template>
                {{}}
            </template>


            <div v-if="store.item" class="pt-2">


                <VhField label="Name">
                    <InputText class="w-full"
                               name="tests-name"
                               data-testid="tests-name"
                               @update:modelValue="store.watchItem"
                               v-model="store.item.name"/>
                </VhField>

                <VhField label="Slug">
                    <InputText class="w-full"
                               name="tests-slug"
                               data-testid="tests-slug"
                               v-model="store.item.slug"/>
                </VhField>

                <VhField label="Email">
                    <InputText class="w-full"
                               name="tests-email"
                               data-testid="tests-email"
                               v-model="store.item.email"/>
                </VhField>

<!--                <VhField label="Taxonomy">

                    {{ store.assets.taxonomy_country_data.map(item => item.parent.name + (item.children.length ? ' (' + item.children.map(child => child.name).join(', ') + ')' : '')).join(', ') }}



                    <Dropdown v-model="store.item.taxonomy_id"
                              :options="store.assets.taxonomy_training_data"
                              optionLabel="name"
                              optionValue="id"
                              placeholder="Select an Item"
                              name="tests-category"
                              data-testid="tests-category"
                              class="w-full md:w-14rem" />
                </VhField>-->



<!--                <VhField label="Country">
                    <Dropdown
                        v-model="store.item.parent_id"
                        :options="store.assets.taxonomy_country_data"
                        optionLabel="parent.name"
                        optionValue="parent.id"
                        placeholder="Select a Country"
                        name="tests-country"
                        data-testid="tests-country"
                        class="w-full md:w-14rem"
                        @change="store.loadChildren()"

                    />
                </VhField>

                <VhField label="State">


                    <Dropdown v-model="store.item.hw_taxonomies_type_id"
                              :options="store.item.child_data"
                              optionLabel="name"
                              optionValue="id"
                              placeholder="Select a State"
                              name="tests-state"
                              data-testid="tests-state"
                              class="w-full md:w-14rem" />
                </VhField>-->

<!--                <VhField label="crud_data">


                    <MultiSelect v-model="store.item.practice_crud"
                                 display="chip"
                                 :options="store.assets.practice_crud_data"
                                 optionLabel="name"
                                 placeholder="Select Tags"
                                 :maxSelectedLabels="3"
                                 name="practices-taxonomy-tag"
                                 data-testid="practices-taxonomy-tag"
                                 class="w-full" />

                </VhField>-->





                <VhField label="Is Active">
                    <InputSwitch v-bind:false-value="0"
                                 v-bind:true-value="1"
                                 class="p-inputswitch-sm"
                                 name="tests-active"
                                 data-testid="tests-active"
                                 v-model="store.item.is_active"/>
                </VhField>

            </div>
        </Panel>

    </div>

</template>
