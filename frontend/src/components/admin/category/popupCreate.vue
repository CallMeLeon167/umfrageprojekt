<template>
  <div class="popup" v-if="show" @click="onOutsideClick">
    <div class="popup-content" @click.stop>
      <h2>Neue Kategorie</h2>
      <form @submit.prevent="onSubmit">
        <label for="categoryName">Kategoriename:</label>
        <input type="text" id="categoryName" v-model="newCategory.name" />
        <br />
        <label for="categoryType">Kategorie Typ:</label>
        <input type="text" id="categoryName" v-model="newCategory.type" />
        <br />
        <button type="submit">Erstellen</button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import {ref, watchEffect} from 'vue'
import {ofetch} from "ofetch";

const newCategory = ref({
  name: "",
  type: ""
})
const emits = defineEmits(['close', 'created']);
const props = defineProps({
  show: {
    type: Boolean,
    required: false,
    default: false
  }
});

const onSubmit = async () => {
  // Hier können Sie die Logik zum Erstellen einer neuen Kategorie hinzufügen
  const errors = validate();
  if (errors.length === 0) {
    await postCategory();
  } else {
    alert(errors.join("\n"));
  }
}

const onOutsideClick = () => {
  emits('close')
}

watchEffect(() => {
  if (!props.show) {
    newCategory.value = {
      name: "",
      type: ""
    }
  }
});

const validate = () => {
  const errors = [];
  if (newCategory.value.name === "") {
    errors.push("Bitte geben Sie einen Namen ein");
  }
  if (newCategory.value.type === "") {
    errors.push("Bitte geben Sie einen Typ ein");
  }
  return errors;
}


const postCategory = async () => {
  const API_URL = import.meta.env.VITE_API_URL;

  const response = await ofetch("/category", {
    baseURL: API_URL,
    method: 'POST',
    headers: {
      'Cookie': 'XDEBUG_SESSION=PHPSTORM',
      'Content-Type': 'application/json'
    },
    credentials: 'include',
    body: JSON.stringify(newCategory.value)
  });

  emits('created')
}

</script>

<style scoped>
.popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(0, 0, 0, 0.5);
}

.popup-content {
  background: white;
  padding: 20px;
  border: 1px solid black;
}
</style>