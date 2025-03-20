<script setup lang="ts">
import type { Office } from '~/types';

const { $api } = useNuxtApp();

// Import Component
const CreateOffice = defineAsyncComponent(() => import('./components/create-office.vue'))

const offices = ref<Office[]>([])
const search_term = ref('');

const is_creating = ref(false);
const is_updating = ref(false);

function fetchOfficeList(name : string = "", code: string = ""){
    $api.get('/offices', {params: {
            name: name,
            code: code,
        }})
        .then((response) => {
            offices.value = response.data
        })
}

function toggleCreate(state : boolean){
    log('Index Emit Event', state)
    is_creating.value = state
}

watchDebounced(search_term, (value) => {
    fetchOfficeList(value)
}, {debounce: 375, maxWait: 1000})

onMounted(() => {
    fetchOfficeList();
})

</script>


<template>
    <div class="flex flex-col items-center h-full p-4">
        <div class="flex flex-col gap-4 max-w-7xl w-full">
            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <h5 class="text-xl">Office Documentations</h5>
                    <div class="flex justify-between gap-4">
                        <TTooltip @click="toggleCreate(true)" text="Add New System">
                            <TButton
                                icon="tabler:plus"
                                size="sm"
                            />
                        </TTooltip>
                    </div>
                </div>
                <p class="text-sm max-w-xl">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nemo earum, quibusdam saepe obcaecati repellat repudiandae officiis, ea exercitationem beatae nihil praesentium, magnam dolores dolorum veritatis explicabo. Aperiam corporis sunt dolorum!</p>
            </div>
            <TInput v-model="search_term" type="text" placeholder="Search for offices"/>
            <div class="grid grid-cols-1 lg:grid-cols-6 justify-center">
                <div v-for="office in offices" class="flex justify-center py-8 border">
                    {{ office.name }}
                </div>
            </div>
        </div>
        <CreateOffice :show="is_creating" @update:show="toggleCreate"></CreateOffice>
    </div>
</template>