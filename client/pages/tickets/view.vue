<script setup lang = "ts">
    // IMPORT
    import { genderData, genderFetchAll } from './data/gender';
    import { modalToggle, modalToggleDefault, modalFormData, modalFormDataDefault, modalFormCNMaxLength, modalFormSchema } from './data/modal';
    import { statusData } from './data/status';

    // COMPONENTS
    // const CompTicketDetails = defineAsyncComponent(() => import('./compontents/view-ticket-details.vue'));

    // DATA
    const { $api } = useNuxtApp();

    const route = useRoute();
    const toast = useToast();

    // TICKET
    const ticketDataSingle = ref();
    const ticketFetchSingle = () => {
        $api.get(`tickets/${route.params.id}`)
            .then((response) => {
                ticketDataSingle.value = response.data;
                modalFormData.value = ticketDataSingle.value;
            });
    };
    const ticketUpdate = () => {
        $api.put(`tickets/${route.params.id}`, modalFormData.value)
            .then(() => {
                modalFormData.value = modalFormDataDefault.value;
                modalToggle.value = modalToggleDefault.value;

                toast.add({
                    title: 'Success',
                    description: 'The ticket was updated successfully.',
                });
            });
    };
    const ticketDelete = () => {
        $api.delete(`tickets/${route.params.id}`)
            .then(() => {
                modalFormData.value = modalFormDataDefault.value;
                modalToggle.value = modalToggleDefault.value;

                toast.add({
                    title: 'Success',
                    description: 'The ticket was deleted successfully.',
                });
            });
    };
    const ticketRestore = () => {
        $api.patch(`tickets/${route.params.id}`)
            .then(() => {
                modalFormData.value = modalFormDataDefault.value;
                modalToggle.value = modalToggleDefault.value;

                toast.add({
                    title: 'Success',
                    description: 'The ticket was restored successfully.',
                });
            });
    };

    // LOAD
    onMounted(() => {
        genderFetchAll();
        ticketFetchSingle();
    });
    
    // AVATAR
    const avatarSeed = computed(() => {
        return ticketDataSingle.value?.violator.first_name.replaceAll(' ', '+');
    });
</script>

<template>
    <div class = "p-4">
        <!-- CARD-->
        <TCard class = "max-w-screen-sm mx-auto w-full">
            <!-- HEADER -->
            <template #header>
                <h1 class = "font-bold">Violation Ticket</h1>
            </template>
            <!-- TICKET -->
            <Suspense>
                <template #default>
                    <div class = "flex gap-4 justify-between p-4">
                        <TAvatar
                            alt = "User Avatar"
                            size = "xl"
                            :src = "`https://api.dicebear.com/9.x/avataaars/svg?seed=${avatarSeed}`"
                        />
                        <div class = "w-full">
                            <p class = "text-sm">ID # <span class = "font-bold">{{ ticketDataSingle?.id }}</span></p>
                            <p class = "text-sm">Citation # <span class = "font-bold">{{ ticketDataSingle?.citation_number }}</span></p>
                            <TBadge
                                size = "xs"
                                variant = "outline"
                                :label = "(ticketDataSingle?.deleted_at !== null) ? 'Soft Deleted' : ticketDataSingle?.status"
                                :color = "(ticketDataSingle?.deleted_at !== null) ? 'gray' : (ticketDataSingle?.status === 'Active') ? 'green' : (ticketDataSingle?.status === 'Pending') ? 'orange' : 'red'"
                            />
                            <hr class = "my-4"/>
                            <h1 class = "font-bold">{{ ticketDataSingle?.violator.full_name }}</h1>
                            <p class = "text-sm">Gender : <span class = "font-bold">{{ ticketDataSingle?.violator.gender }}</span></p>
                        </div>
                    </div>
                </template>
                <template #fallback>
                    <!-- WIP -->
                    <div class = "flex justify-center items-center">
                        <div
                            class="animate-spin border-4 border-primary border-t-transparent rounded-full w-5 h-5 mr-2">
                        </div>
                    </div>
                </template>
            </Suspense>
            <!-- ACTION -->
            <div class = "flex gap-4 justify-between p-4">
                <div class = "w-full">
                    <TButton
                        icon = "i-heroicons-arrow-left"
                        class = "justify-center"
                        color = "gray"
                        variant = "outline"
                        :to = "{ name: 'tickets-index' }"
                        block
                    >
                        Back to List
                    </TButton>
                </div>
                <div
                    class = "w-full"
                    v-show = "(ticketDataSingle?.deleted_at === null)"
                >
                    <TButton
                        icon = "i-heroicons-arrow-path"
                        class = "justify-center w-full"
                        color = "blue"
                        variant = "outline"
                        :disabled = "(ticketDataSingle?.deleted_at !== null) ? true : false"
                        @click = "modalToggle = true"
                    >
                        Update
                    </TButton>
                </div>
                <div
                    class = "w-full"
                    v-show = "(ticketDataSingle?.deleted_at !== null)"
                >
                    <TButton
                        icon = "i-heroicons-archive-box"
                        class = "justify-center w-full"
                        color = "orange"
                        variant = "outline"
                        :disabled = "(ticketDataSingle?.deleted_at !== null) ? false : true"
                        @click = "ticketRestore"
                    >
                        Restore
                    </TButton>
                </div>
                <div
                    class = "w-full"
                    v-show = "(ticketDataSingle?.deleted_at === null)"
                >
                    <TButton
                        icon = "i-heroicons-trash"
                        class = "justify-center w-full"
                        color = "red"
                        variant = "outline"
                        :disabled = "(ticketDataSingle?.deleted_at !== null) ? true : false"
                        @click = "ticketDelete"
                    >
                        Delete
                    </TButton>
                </div>
            </div>
        </TCard>
        <!-- MODAL -->
        <TModal v-model = "modalToggle" prevent-close>
            <TCard class = "max-w-screen-sm mx-auto w-full">
                <!-- HEADER | CLOSE-->
                <template #header>
                    <h1 class = "font-bold">Update Ticket</h1>
                    <TButton
                        icon = "i-heroicons-x-mark"
                        class = "m-0 p-0"
                        color = "gray"
                        variant = "ghost"
                        @click = "modalToggle = false"
                    />
                </template>
                <!-- FORM -->
                <TForm
                    :state = "modalFormData"
                    :schema = "modalFormSchema"
                >
                    <!-- CITATION NUMBER | STATUS -->
                    <div class = "flex gap-4 justify-between p-4">
                        <TFormGroup class = "w-full" label = "Citation Number" name = "citation_number">
                            <TInput
                                placeholder = "123-4567-8910"
                                autocomplete = "off"
                                v-model = "modalFormData.citation_number"
                                :maxlength = "modalFormCNMaxLength"
                            />
                        </TFormGroup>
                        <TFormGroup class = "w-full" label = "Status" name = "status">
                            <TInputMenu
                                by = "id"
                                placeholder = "Select status"
                                option-attribute = "name"
                                v-model = "modalFormData.status"
                                :options = "statusData"
                                :search-attributes = "['name']"
                                @update:modelValue = "(selected) => modalFormData.status = selected ? String(selected.name) : ''"
                            >
                            </TInputMenu>
                        </TFormGroup>
                    </div>
                    <!-- FIRST NAME | MIDDLE NAME -->
                    <div class = "flex gap-4 justify-between p-4">
                        <TFormGroup class = "w-full" label = "First Name">
                            <TInput
                                placeholder = "John"
                                autocomplete = "off"
                                v-model = "modalFormData.violator.first_name"
                            />
                        </TFormGroup>
                        <TFormGroup class = "w-full" label = "Middle Name">
                            <TInput
                                placeholder = "Michael"
                                autocomplete = "off"
                                v-model = "modalFormData.violator.middle_name"
                            />
                        </TFormGroup>
                    </div>
                    <!-- LAST NAME | GENDER -->
                    <div class = "flex gap-4 justify-between p-4">
                        <TFormGroup class = "w-full" label = "Last Name">
                            <TInput
                                placeholder = "Doe"
                                autocomplete = "off"
                                v-model = "modalFormData.violator.last_name"
                            />
                        </TFormGroup>
                        <TFormGroup class = "w-full" label = "Gender">
                            <TSelect
                                placeholder = "Select gender"
                                value-attribute = "id"
                                option-attribute = "name"
                                v-model = "modalFormData.violator.gender_id"
                                :options = "genderData"
                            />
                        </TFormGroup>
                    </div>
                    <!-- SUBMIT -->
                    <div class = "flex justify-between p-4">
                        <TButton
                            icon = "i-heroicons-arrow-path"
                            size = "sm"
                            type = "submit"
                            class = "justify-center w-full"
                            color = "blue"
                            variant = "outline"
                            @click = "ticketUpdate"
                        >
                            Update
                        </TButton>
                    </div>
                </TForm>
            </TCard>
        </TModal>
    </div>
</template>