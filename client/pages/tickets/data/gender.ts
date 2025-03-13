// EXPORT (variables)
export const genderData = ref([]);

// EXPORT (functions)
export const genderFetchAll = () => {
    const { $api } = useNuxtApp();

    $api.get('genders')
        .then((response) => {
            genderData.value = response.data;
        });
};