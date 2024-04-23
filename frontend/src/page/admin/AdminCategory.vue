<template>
  <h2>Kategorieles</h2>
  <button @click="createCategory">Kategorie erstellen</button>
  <PopupCreateCategory :show="showPopup" @created="onCategoryCreated" @close="showPopup = false" />
  <button @click="fetchCategories">Kategorien laden</button>
  <table class="category-table" v-if="!isLoading">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Optionen</th>
      </tr>
    </thead>
    <tbody v-if="categories.length > 0">
      <tr v-for="category in categories" :key="category.id">
        <td>{{ category.id }}</td>
        <td>{{ category.name }}</td>
        <td>{{ category.type }}</td>
        <td>
          <button disabled>Bearbeiten</button>
          <button @click="onDeleteCategory(category.id)">Löschen</button>
        </td>
      </tr>
    </tbody>
    <tbody v-else>
      <tr>
        <td colspan="4">Keine Kategorien vorhanden</td>
      </tr>
    </tbody>
  </table>
  <div v-else>
    Lade Kategorien...
  </div>

</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { ref } from "vue";
import PopupCreateCategory from "@/components/admin/category/popupCreate.vue";
import type { Category } from "@/types/survey";
import { ofetch } from "ofetch";

const router = useRouter();

const showPopup = ref(false)
const categories = ref<Category[]>([])
const isLoading = ref(true)

const createCategory = () => {
  showPopup.value = true;
}

const onCategoryCreated = () => {
  showPopup.value = false;
  fetchCategories();
}

const fetchCategories = async () => {
  isLoading.value = true;
  const API_URL = import.meta.env.VITE_API_URL

  const response = await ofetch("/category", {
    baseURL: API_URL,
    method: 'GET',
    headers: {
      'Cookie': 'XDEBUG_SESSION=PHPSTORM'
    }
  });
  console.log(response);
  categories.value = response || [];
  isLoading.value = false;
}

const onDeleteCategory = async (id: number | string) => {
  const API_URL = import.meta.env.VITE_API_URL

  const response = fetch(`${API_URL}/category/${id}`, {
    method: 'DELETE',
  });
  console.log(response);
  fetchCategories();
}

fetchCategories();
</script>