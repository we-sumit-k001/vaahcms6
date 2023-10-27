<script setup>
import { vaah } from '../../vaahvue/pinia/vaah'
import { useTestStore } from '../../stores/store-tests'
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import Dialog from 'primevue/dialog';

const store = useTestStore();
const useVaah = vaah();
const route = useRoute();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if (route.params && !route.params.id) {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    /**
     * Fetch item users from the database
     */
    if (store.item && !store.practice_crud) {
        await store.getTestPractice();
    }

    /**
     * Fetch user menu item from store
     */
    await store.getPracticeCrudMenuItems();
});

//--------toggle item menu--------//
const item_menu_state = ref();
const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------toggle item menu--------//

</script>
<template>
    <div class="col-5" >
        <Panel v-if="store && store.item">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="font-semibold text-sm">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>


                <div class="p-inputgroup">
                    <Button label="Edit"
                            class="p-button-sm"
                            @click="store.toEdit(store.item)"
                            data-testid="tests-item-to-edit"
                            icon="pi pi-save"/>

                    <!--item_menu-->
                    <Button
                        type="button"
                        class="p-button-sm"
                        @click="toggleItemMenu"
                        data-testid="tests-item-menu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="item_menu_state"
                          :model="store.practice_crud_menu_items"
                          :popup="true" />
                    <!--/item_menu-->

                    <Button class="p-button-primary p-button-sm"
                            icon="pi pi-times"
                            data-testid="tests-item-to-list"
                            @click="store.toList()"/>

                </div>



            </template>

            <div class="grid p-fluid">
                <div class="col-12">
                    <div class="p-inputgroup">
                         <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText class="w-full p-inputtext-sm"
                                       placeholder="Search"
                                       type="text"
                                       v-model="store.practice_crud_query.q"
                                       @keyup.enter="store.delayedPracticeCrudSearch()"
                                       @keyup.enter.native="store.delayedPracticeCrudSearch()"
                                       @keyup.13="store.delayedPracticeCrudSearch()"

                            />
                         </span>

                        <Button class="p-button-sm"
                                label="Reset"
                                data-testid="users-role_reset"
                                @click="store.resetPracticeCrudFilters()"

                        />
                    </div>
                </div>
            </div>

            <Divider />

            <div>
                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                    <div >
                        <DataTable v-if="store && store.practice_crud"
                                   :value="store.practice_crud.list.data"
                                   dataKey="id"
                                   class="p-datatable-sm"
                                   stripedRows
                                   responsiveLayout="scroll"
                        >
                            <Column field="name"
                                    header="Name"
                            >
                                <template #body="prop">
                                    {{ prop.data.name }}
                                </template>
                            </Column>


                            <Column field="" header="Has Practice">
                                <template #body="prop">
                                    <Button label="Yes"
                                            class="p-button-sm p-button-success p-button-rounded"
                                            v-if="prop.data.pivot.is_active === 1"
                                            @click="store.changePracticeTest(prop.data)"
                                            data-testid="role-user_status_yes"
                                    />

                                    <Button label="No"
                                            class="p-button-sm p-button-danger p-button-rounded"
                                            data-testid="role-user_status_no"
                                            v-else
                                            @click="store.changePracticeTest(prop.data)"
                                    />
                                </template>
                            </Column>

                            <Column field="" header="View">
                                <template #body="prop">


                                    <Button class="p-button-sm p-button-rounded p-button-outlined"
                                            v-tooltip.top="'View'"
                                            @click="store.showModal(prop.data)"
                                            data-testid="users-role_details_view"
                                            icon="pi pi-eye"
                                            label="View"
                                    />
                                </template>
                            </Column>
                        </DataTable>

                            <Paginator v-if="store && store.practice_crud"
                                       v-model:rows="store.practice_crud_query.rows"
                                       :totalRecords="store.practice_crud.list.total"
                                       @page="store.practicePaginate($event)"
                                       :rowsPerPageOptions="store.rows_per_page"
                                       class="bg-white-alpha-0 pt-2"
                            />

                    </div>

                </div>
            </div>
        </Panel>

        <Dialog header="Details"
                v-model:visible="store.displayModal"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
                :modal="true"
        >
            <div v-for="(item,index) in store.modalData" :key="index">

                <span> {{ index }} </span> : {{ item }}


                <Divider />
            </div>
        </Dialog>
    </div>
</template>
