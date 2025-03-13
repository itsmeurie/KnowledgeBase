import { ref } from "vue";

const isOpenCreateViolator = ref(false);
const isOpenUpdateViolator = ref(false);

export function useViolatorModal() {
  const openModal = () => {
    isOpenCreateViolator.value = true;
  };

  const closeModal = () => {
    isOpenCreateViolator.value = false;
  };

  const openUpdateModal = () => {
    isOpenUpdateViolator.value = true;
  };

  const closeUpdateModal = () => {
    isOpenUpdateViolator.value = false;
  };

  return {
    isOpenCreateViolator,
    openModal,
    closeModal,
    isOpenUpdateViolator,
    openUpdateModal,
    closeUpdateModal
  };
}
