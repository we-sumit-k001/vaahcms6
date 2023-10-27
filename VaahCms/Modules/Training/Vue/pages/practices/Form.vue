<script setup>
import {onMounted, ref, watch} from "vue";
import { usePracticeStore } from '../../stores/store-practices'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'

import FileUploader from './components/FileUploader.vue'
import {useRoute} from 'vue-router';


const store = usePracticeStore();

const route = useRoute();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }

    await store.getFormMenu();
});

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

const handleFileUploaded = (responseData) => {

    if (responseData.data && responseData.data.url) {

        store.item.file_link=responseData.data.url


    } else {

        console.error('image not found');
    }

    response.value = JSON.stringify(responseData, null, 2);

};

const removeImage = () => {

    store.item.file_link = '';
};

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
                            data-testid="practices-save"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"/>

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            class="p-button-sm"
                            data-testid="practices-create-and-new"
                            icon="pi pi-save"/>


                    <!--form_menu-->
                    <Button
                        type="button"
                        @click="toggleFormMenu"
                        class="p-button-sm"
                        data-testid="practices-form-menu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true" />
                    <!--/form_menu-->


                    <Button class="p-button-primary p-button-sm"
                            icon="pi pi-times"
                            data-testid="practices-to-list"
                            @click="store.toList()">
                    </Button>
                </div>



            </template>


            <div v-if="store.item" class="pt-2">

<!--                {{store.item}}-->

                <VhField label="Name">
                    <InputText class="w-full"
                               name="practices-name"
                               data-testid="practices-name"
                               @update:modelValue="store.watchItem"
                               v-model="store.item.name"/>
                </VhField>

                <VhField label="Slug">
                    <InputText class="w-full"
                               name="practices-slug"
                               data-testid="practices-slug"
                               v-model="store.item.slug"/>
                </VhField>


                <VhField label="Train_Tag">

                    {{store.item.tags}}

                    <MultiSelect v-model="store.item.tags"
                                 display="chip"
                                 :options="store.assets.taxonomy_training_tag"
                                 optionLabel="name"
                                 placeholder="Select Tags"
                                 :maxSelectedLabels="3"
                                 name="practices-taxonomy-tag"
                                 data-testid="practices-taxonomy-tag"
                                 class="w-full" />

                </VhField>



                <VhField label="Training">

                    <Dropdown v-model="store.item.taxonomy_training_id"
                              :options="store.assets.taxonomy_training_data"
                              optionLabel="name"
                              optionValue="id"
                              placeholder="Select an Item"
                              name="practices-category"
                              data-testid="practices-category"
                              class="w-full md:w-14rem" />
                </VhField>

                <VhField label="Upload">

                    <FileUploader placeholder="Upload Avatar"
                                  v-model="store.item.file_link"
                                  :is_basic="true"
                                  data-testid="practices_upload_avatar"
                                  :auto_upload="true"
                                  :uploadUrl="store.assets.urls.upload"
                                  @fileUploaded="handleFileUploaded">
                    </FileUploader>

                    <img v-if="store.item.file_link"
                         :src="store.item.file_link"
                         width="64"
                         height="64"
                         alt="Uploaded Image"/>
                    <Button v-if="store.item.file_link"
                            icon="pi pi-times"
                            severity="danger"
                            @click="removeImage"
                            text rounded aria-label="Cancel"
                            class="close-button"
                    />





                </VhField>


                <VhField label="Is Active">
                    <InputSwitch v-bind:false-value="0"
                                 v-bind:true-value="1"
                                 class="p-inputswitch-sm"
                                 name="practices-active"
                                 data-testid="practices-active"
                                 v-model="store.item.is_active"/>
                </VhField>

            </div>
        </Panel>

    </div>

</template>

<style scoped>
.close-button {
    position: absolute;
    margin: 4px;
    cursor: pointer;

}
img{
    margin-top:1rem;

    margin-left:1rem
}

</style>
