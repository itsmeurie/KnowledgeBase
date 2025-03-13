<script setup lang = "ts">
    // IMPORT
    import { genderData, genderFetchAll } from './data/gender';
    import { modalToggle, modalToggleDefault, modalFormData, modalFormDataDefault, modalFormCNMaxLength, modalFormSchema } from './data/modal';
    import { statusData } from './data/status';

    // DATA
    const router = useRouter();

    // TICKET
    type Ticket = {
        id: number,
        citation_number: string,
        status: string,
        violator: {
            id: number,
            first_name: string,
            middle_name: string,
            last_name: string,
            gender: string,
            full_name: string,
        },
        created_at: string,
    };

    const ticketDataAll = ref([]);
    const ticketColumns = [{
            label: 'ID',
            key: 'id',
            sortable: true,
        }, {
            label: 'Violator',
            key: 'violator.full_name',
            sortable: true,
        }, {
            label: 'Citation Number',
            key: 'citation_number',
            sortable: true,
        }, {
            label: 'Created At',
            key: 'created_at',
            sortable: true,
        }, {
            label: 'Status',
            key: 'status',
            sortable: true,
        }, {
            key: 'actions',
        },
    ];

    const ticketFetchAll = async () => {
        const { data } = await search();

        ticketDataAll.value = data.data;
    };
    const ticketCreate = () => {
        const { $api } = useNuxtApp();

        const toast = useToast();

        $api.post('tickets', modalFormData.value)
            .then(() => {
                modalFormData.value = modalFormDataDefault.value;
                modalToggle.value = modalToggleDefault.value;

                toast.add({
                    title: 'Success',
                    description: 'The ticket was created successfully.',
                });
                ticketFetchAll();
            });
    };
    const ticketAction = (row : Ticket) => [
        [{
            label: 'View',
            icon: 'i-heroicons-user',
            click: () => {
                router.push({ name: 'tickets-view', params: { id: row.id, citation_number: row.citation_number, }, });
            },
        }],
    ];

    // PAGINATION
    const { search, pagination } = useSearcher({
        api: 'tickets',
        limit: 25, 
        method: 'get',
        onPageChange: ticketFetchAll,
    });
    // @ts-ignore
    watch(() => pagination.page, async() => await search());

    // LOAD
    onMounted(() => {
        genderFetchAll();
        ticketFetchAll();
    });
</script>

<template>
    <div class = "max-w-screen-xl mx-auto p-8 w-full">
        <!-- HEADER -->
        <header class = "flex items-center justify-between py-2">
            <h1 class = "font-bold">Tickets</h1>
            <TButton
                icon = "i-heroicons-pencil-square"
                size = "sm"
                color = "emerald"
                label = "Create New Ticket"
                variant = "outline"
                @click = "modalToggle = true"
            />
        </header>
        <!-- TABLE -->
        <TTable
            :rows = "ticketDataAll"
            :columns = "ticketColumns"
        >
            <template #status-data = "{ row }">
                <TBadge
                    size = "xs"
                    class = "flex justify-center"
                    variant = "outline"
                    :label = "(row.deleted_at !== null) ? 'Soft Deleted' : row.status"
                    :color = "(row.deleted_at !== null) ? 'gray' : (row.status === 'Active') ? 'green' : (row.status === 'Pending') ? 'orange' : 'red'"
                />
            </template>
            <template #actions-data = "{ row }">
                <TDropdown :items = "ticketAction(row)">
                    <TButton
                        icon = "i-heroicons-ellipsis-horizontal"
                        color = "gray"
                        variant = "ghost"
                    />
                </TDropdown>
            </template>
        </TTable>
        <!-- PAGINATION -->
        <TPagination
            v-model = "pagination.page"
            :total = "pagination.total"
            :page-count = "pagination.limit"
        />
        <!-- MODAL -->
        <TModal v-model = "modalToggle" prevent-close>
            <TCard class = "max-w-screen-sm mx-auto w-full">
                <!-- HEADER | CLOSE-->
                <template #header>
                    <h1 class = "font-bold">Create Ticket</h1>
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
                            <TSelect
                                placeholder = "Select status"
                                v-model = "modalFormData.status"
                                :options = "statusData"
                            />
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
                            icon = "i-heroicons-plus"
                            size = "sm"
                            type = "submit"
                            class = "justify-center w-full"
                            color = "emerald"
                            value = "Submit"
                            variant = "outline"
                            @click = "ticketCreate"
                        >
                            Submit
                        </TButton>
                    </div>
                </TForm>
            </TCard>
        </TModal>
    </div>
</template>
