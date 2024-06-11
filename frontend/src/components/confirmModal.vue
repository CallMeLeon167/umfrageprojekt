<template>
  <div class="popup" v-if="show" @click="onOutsideClick">
    <div class="popup-content" @click.stop>
      <h2>{{ props.title }}</h2>
      <p>{{ props.description }}</p>
      <div>
        <button @click="onCancel">Abbrechen</button>
        <button @click="onConfirm">{{ props.confirmText }}</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  show: {
    type: Boolean,
    required: true,
    default: false
  },
  title: {
    type: String,
    required: false,
    default: 'Neue Kategorie'
  },
  description: {
    type: String,
    required: false,
    default: 'Kategoriename:'
  },
  confirmText: {
    type: String,
    required: false,
    default: 'Bestätigen'
  }
})

const emits = defineEmits(['close', 'confirm'])

const onOutsideClick = () => {
  emits('close')
}

const onCancel = () => {
  emits('close')
}

const onConfirm = () => {
  emits('confirm')
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
