<script setup lang = "ts">
    const ticketFetchSingle = () => {
        $api.get(`tickets/${route.params.id}`)
            .then((response) => {
                ticketDataSingle.value = response.data;
            });
    };
</script>
<template>
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